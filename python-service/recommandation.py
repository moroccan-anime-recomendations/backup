from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import List, Optional
import google.generativeai as genai 
from dotenv import load_dotenv
import os
import json
import re

# Charger les variables d'environnement
load_dotenv()

# Configurer l'API Gemini
GEMINI_API_KEY = os.getenv("GEMINI_API_KEY")
if not GEMINI_API_KEY:
    raise ValueError("La clé API Gemini n'est pas définie dans les variables d'environnement")

genai.configure(api_key=GEMINI_API_KEY)

# Initialiser l'application FastAPI
app = FastAPI(
    title="API de Recommandation d'Animes Marocains en Darija",
    description="Service de recommandation d'animes basé sur Gemini"
)

# Modèles de données
class Favoris(BaseModel):
    user_id: int
    animes_favoris: List[str]

class Recommendation(BaseModel):
    title: str
    reason: str

class RecommendationResponse(BaseModel):
    recommendations: List[Recommendation]
    original_response: Optional[str] = None

# Endpoint de recommandation
@app.post("/recommendation", response_model=RecommendationResponse)
async def recommander(favoris: Favoris):
    try:
        # Construire le prompt en darija
        prompt = f"""
        انت مساعد توصيات لأنمي مغربي. المستخدم كيعجبو هاد الأنميات: 
        {', '.join(favoris.animes_favoris)}. 
        
        عطيني 3 توصيات ديال أنميات زوينة بحالهم، ولكن ماشي مكررين، وشرح علاش 
         نصحتيني بيهم، وبالدارجة المغربية وحتا الاسماء ديالهم بالدارجة و حاول تفاد الخط باش اكون  من ليمن ليسر. 
        
        تكون الإجابة ديالك بهاد الشكل بالضبط (JSON)، بلا مقدمة ولا خاتمة:
        
        [
          {{
            "title": "اسم الأنمي",
            "reason": "سبب التوصية بالدارجة المغربية"
            ...
          }},
          ...
        ]
        """

        # Appeler l'API Gemini
        model = genai.GenerativeModel("gemini-2.0-flash")
        response = await model.generate_content_async(prompt)
        
        # Récupérer le texte de la réponse
        response_text = response.text
        
        # Essayer d'extraire le JSON de la réponse
        # D'abord, chercher un tableau JSON entre crochets
        json_match = re.search(r'\[(.*?)\]', response_text, re.DOTALL)
        
        recommendations_data = []
        if json_match:
            # Nettoyer et parser le JSON
            json_content = f"[{json_match.group(1)}]"
            json_content = json_content.replace('```json', '').replace('```', '')
            recommendations_data = json.loads(json_content)
        else:
            # Si aucun JSON n'est trouvé, essayer de parser manuellement la réponse
            # Ce bloc est utile si Gemini ne répond pas en format JSON
            recommendations_data = []
            for match in re.finditer(r'(\d+)\.\s*([^:]+):?\s*(.+?)(?=\d+\.|$)', response_text, re.DOTALL):
                recommendations_data.append({
                    "title": match.group(2).strip(),
                    "reason": match.group(3).strip()
                })
        
        # Convertir les données en objets Recommendation
        recommendations = []
        for item in recommendations_data:
            recommendations.append(Recommendation(
                title=item.get("title", "Titre non disponible"),
                reason=item.get("reason", "Raison non disponible")
            ))
        
        # Si aucune recommandation n'a été trouvée, utiliser une approche de secours
        if not recommendations:
            # Diviser la réponse par lignes et chercher des recommandations
            lines = response_text.split('\n')
            current_title = None
            current_reason = None
            
            for line in lines:
                if line.strip() and (line.strip().startswith('1.') or current_title is None):
                    # Nouvelle recommandation
                    if current_title:
                        recommendations.append(Recommendation(
                            title=current_title,
                            reason=current_reason or "Raison non spécifiée"
                        ))
                    
                    # Essayer d'extraire le titre
                    title_match = re.search(r'\d+\.\s*([^–\-:]+)', line)
                    if title_match:
                        current_title = title_match.group(1).strip()
                        # Extraire la raison si elle est sur la même ligne
                        reason_match = re.search(r'[–\-:]\s*(.+)', line)
                        current_reason = reason_match.group(1).strip() if reason_match else None
                    else:
                        current_title = line.strip()
                        current_reason = None
                elif current_title and line.strip():
                    # Ajouter à la raison actuelle
                    if current_reason:
                        current_reason += " " + line.strip()
                    else:
                        current_reason = line.strip()
            
            # Ajouter la dernière recommandation
            if current_title:
                recommendations.append(Recommendation(
                    title=current_title,
                    reason=current_reason or "Raison non spécifiée"
                ))
        
        # S'assurer qu'il y a au moins une recommandation
        if not recommendations:
            recommendations = [
                Recommendation(
                    title="Erreur de traitement",
                    reason="Impossible d'extraire les recommandations de la réponse."
                )
            ]
        
        return RecommendationResponse(
            recommendations=recommendations,
            original_response=response_text
        )
        
    except Exception as e:
        # Gérer les erreurs et fournir un message clair
        print(f"Erreur lors de la génération des recommandations: {str(e)}")
        print(f"Réponse brute (si disponible): {getattr(response, 'text', 'Non disponible')}")
        
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de la génération des recommandations: {str(e)}"
        )

# Route principale
@app.get("/")
async def root():
    return {"message": "API de Recommandation d'Animes Marocains en Darija"}

# Exécuter l'application
if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8000)