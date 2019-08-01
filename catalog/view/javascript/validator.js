class Validator {
    constructor() {
        console.log("[INFO] Loaded validator.js for local validation");
    }

    name(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length < lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    surname(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length < lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    street(text, lengthMin, lengthMax) {
        if (text.length > lengthMin && text.length < lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F ]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(text);
        }
        return false;
    }

    email(email) {
        var re = /^(([^<>()\[\]\\.,:\s@"]+(\.[^<>()\[\]\\.,:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        var notAccents = /[\u00C0-\u017F]/;
        if (email.length > 0) {
            if(re.test(email)){
                return !notAccents.test(email);
            }
        }
        return false;
    }

    website(website){
        var re = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
        if(website.length > 0){
            return re.test(website);
        }
        return false;
    }

    companyName(companyName, lengthMin, lengthMax){
        if (companyName.length > lengthMin && companyName.length < lengthMax) {
            var allChars = /^\s*([A-Za-z\u00C0-\u017F 0-9]{1,}([\.,]|[-']|))*$/i;
            return allChars.test(companyName);
        }
        return false;
    }

    city(city) {
        var re = /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/;
        if (city.length > 0) {
            return re.test(city);
        }
        return false;
    }

    phone(number) {
        if (number.length > 0) {
            var re = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;
            return re.test(number);
        }
        return false
    }

    houseNumber(numeroCivico) {
        var re = /^[a-zA-Z0-9 ]+$/;
        if (numeroCivico.length > 0) {
            return re.test(numeroCivico);
        }
        return false;
    }
}