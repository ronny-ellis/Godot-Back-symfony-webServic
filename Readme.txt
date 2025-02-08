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
    
Api:
    PlatApiLink:
        Method POST:
            link:
                {link}/api/plats
            json:
                {
                     "nom":"Fondu au fromage",
		             "recette":{
				        "id":1
		             }
                }
        Method GET:
            link:
                {link}/api/plats
                {link}/api/{id}

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
                {link}/api/recettes
                {link}/api/recettes/{id}
    IngredientApi:
        Method POST:
            link:
                {link}/api/ingredients
            json:
                {
                    "nom":"Tomate"
                }               
        Method GET:
            link:
                {link}/api/ingredients
                {link}/api/ingredients/{id}