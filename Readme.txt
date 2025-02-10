Entity:
    Plat(id,nom);
    Recette(id,idPlat,idIngredient);
    Ingredient(id,nom);
    Historique(id,idPlat,Achat dateTime);
    Reservation(id,idPlat,idClient,Achat dateTime);

Controller:
    RecetteApi:
        Method GET
            getRecette();
            getRecetteById(id);
        Method POST:
            createRecette(nom,idPlat,idRecette);
    PlatApi:
        Method GET:
            getPlat();
            getPlatById(Id);
        Method POST:
            createPlat(nom);
    IngredientApi:
        Method GET:
            getIngredient();
            getIngredientById(id);
        Method POST:
            createIngredient(nom)
    HistoriqueApi():
        Method POST:
            createHistorique(id,idPlat,desc,refClient,dateTime);
        Method GET:
            getHistorique();
            getHistoriqueById(id);
            getHistoriqueByPlat(idPlat);
            getHistoriqueByRefClient(idClient);
    ReservationControllerApi:
        Method POST:
            createReservation();
        Method GET:
            getReservation();
            getReservationById(id);
            getReservation(idPlat);
            getReservation(idClient);
    
APIResource:
    PlatApiLink:
        Method POST:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/plats
            json:
                {
	                "nom":"Soupe A",
			        "ingredients":[
				        {
					        "id":1
				        },
				        {
					        "id":2
				        }
			        ],
	                "prix":2000,
	                "tempsDeCuisson":"00:03:00"
                }

        Method GET:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/plats
                https://godot-back-symfony-webservic-production.up.railway.app/api/{id}

    RecetteApi:
        Method POST:
            link:
                {link}/api/recettes
            json:
                {
	                "ingredients":[
		                {"id":1},
		                {"id":2},
		                {"id":3}
	                ]
                }
        Method GET:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/recettes
                https://godot-back-symfony-webservic-production.up.railway.app/api/recettes/{id}
    IngredientApi:
        Method POST:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/ingredients
            json:
                {
                    "nom":"Tomate"
                }               
        Method GET:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/ingredients
                https://godot-back-symfony-webservic-production.up.railway.app/api/ingredients/{id}
    CommandeApi
        Method POST:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/commandes
            json:
                { "idUser":"1",
	                "plat":
	                [
		                {
			                "id":1
		                }
	                ],
	                "estRecu":false,
                    "estTermine":false,
                    "quantite":10
                }
        Method GET:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/commandes
                https://godot-back-symfony-webservic-production.up.railway.app/api/commandes/{id}
        Method PUT:
            link:
                https://godot-back-symfony-webservic-production.up.railway.app/api/commandes/validation/{id}