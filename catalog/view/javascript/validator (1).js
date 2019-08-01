var companyname;
var region;
var postalcode;
var street;
var housenumber;
var city;
var nap;
var phone;
var email;
var website;
var firstname;
var lastname;
var validated = [false,false,false,false,false,false,false,false,false,false];

$('input[name=firstnome]').keyup(function(event){
    nome = $('input[name=firstnome]').val();
    setIcon('#indNome', valName(nome));
});

    textValidation(id, text){
        var regex = /^[a-zA-Z àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĆČĖĘÈÉÊËÌÍÎÏĮŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑČŠŽ]+$/;
        if(text != null && regex.test(text) && text.length <= 50){
            document.getElementById(id).style.borderColor = "green";
            testo = true;
        }else {
            document.getElementById(id).style.borderColor = "red";
            testo = false;
        }
        enableButton();
    }
    capValidation(id, text){
        var regex = /^[a-zA-Z0-9]+$/;
        if(text != null && regex.test(text) && text.length <= 5){
            document.getElementById(id).style.borderColor = "green";
            cap = true;
        }else{
            document.getElementById(id).style.borderColor = "red";
            cap = false;
        }
        enableButton();
    }
    civicNumberValidation(id, text){
        var regex = /^[0-9]+[a-zA-Z]{0,3}$/;
        if(text != null && regex.test(text) && text.length <= 4){
            document.getElementById(id).style.borderColor = "green";
            number = true;
        }else{
            document.getElementById(id).style.borderColor = "red";
            number = false;
        }
        enableButton();
    }
    phoneValidator(id, text){
        var regex = /^[\+]?[0-9 ]{10,15}$/;
        if(regex.test(text)){
            document.getElementById(id).style.borderColor = "green";
            phone = true;
        }else{
            document.getElementById(id).style.borderColor = "red";
            phone = false;
        }
        enableButton();
    }
    emailValidator(id, text){
        var regex = /^([A-Za-z0-9._%+-])+@([A-Za-z0-9.-])+\.([A-Za-z]){2,4}/;
        if(text != null && regex.test(text) && text.length < 50){
            document.getElementById(id).style.borderColor = "green";
            email = true;
        }else{
            document.getElementById(id).style.borderColor = "red";
            email = false;
        }
        enableButton();
    }
    
    enableButton(){
        if(companyname && region && postalcode && city && street && housenumber && phone && nap && firstname && lastname && email){
            document.getElementById("submit").disabled = false;
        }else{
            document.getElementById("submit").disabled = true;		
        }
    }