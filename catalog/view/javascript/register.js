var validator = new validator();

function addListeners() {
    //Aggiunge evento keydown ai campi
    $("#first_name").keydown(function () {
        manage(this, "name");
    });
    $("#last_name").keydown(function () {
        manage(this, "surname");
    });
    $("#website").keydown(function () {
        manage(this, "website");
    });
    $("#email").keydown(function () {
        manage(this, "email");
    });
    $("#city").keydown(function () {
        manage(this, "city");
    });
    $("#companyName").keydown(function () {
        manage(this, "companyName");
    });
    $("#street").keydown(function () {
        manage(this, "street");
    });
    $("#houseNumber").keydown(function () {
        manage(this, "houseNumber");
    });
    $("#phone").keydown(function () {
        manage(this, "phone");
    });


    //Aggiunge evento keyup ai campi
    $("#first_name").keyup(function () {
        manage(this, "name");
    });
    $("#last_name").keyup(function () {
        manage(this, "surname");
    });
    $("#website").keyup(function () {
        manage(this, "website");
    });
    $("#email").keyup(function () {
        manage(this, "email");
    });
    $("#city").keyup(function () {
        manage(this, "city");
    });
    $("#companyName").keyup(function () {
        manage(this, "companyName");
    });
    $("#street").keyup(function () {
        manage(this, "street");
    });
    $("#houseNumber").keyup(function () {
        manage(this, "houseNumber");
    });
    $("#phone").keyup(function () {
        manage(this, "phone");
    });
}
function checkAnyError() {
    var changed = false;

    if (manage(document.getElementById('first_name'), "nome") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo nome</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('last_name'), "cognome") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo cognome</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('data_nascita'), "data") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo Data</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('email'), "email") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo Email</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('citta'), "citta") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo Città</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('cap'), "cap") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo CAP</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('via'), "via") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo Via</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('numero_civico'), "civico") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;margin-right:10px;">Errore: </span><span> Campo Numero civico</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }
    if (manage(document.getElementById('phone'), "phone") == false) {
        var toastHTML = '<span style="color:red;font-weight:bold;">Errore: </span><span> Campo Telefono</span>';
        M.toast({
            html: toastHTML
        });
        changed = true;
    }

    if (changed) return false;

    return true;
}

//PARAMS
const global_length_min = 0;
const global_length_max = 50;

function manage(obj, selector) {
    var status = false;
        
    obj.value = obj.value.replace(/\s\s+/i, ' ');

    obj.value = obj.value.replace(/[;]+/i, '');

    if (selector == "name") {
        status = validator.name(obj.value, global_length_min, global_length_max);
    } else if (selector == "surname") {
        status = validator.surname(obj.value, global_length_min, global_length_max);
    } else if (selector == "website") {
        status = validator.website(obj.value);
    } else if (selector == "city") {
        status = validator.city(obj.value)
    } else if (selector == "email") {
        status = validator.email(obj.value)
    } else if (selector == "companyName") {
        status = validator.companyName(obj.value, global_length_min, global_length_max);
    } else if (selector == "houseNumber") {
        status = validator.houseNumber(obj.value);
    } else if (selector == "street") {
        status = validator.street(obj.value, global_length_min, global_length_max);
    } else if (selector == "phone") {
        status = validator.phone(obj.value);
    }

    if (status) {
        obj.style.borderBottom = "1px solid #4CAF50";
        obj.style.boxShadow = "0 1px 0 0 #4CAF50";
    } else {
        obj.style.borderBottom = "1px solid #FF0000";
        obj.style.boxShadow = "0 1px 0 0 #FF0000";
    }
    return status;
}