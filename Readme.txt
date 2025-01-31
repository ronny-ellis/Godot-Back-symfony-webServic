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
    