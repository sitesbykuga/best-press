/*Обход автозаполнения полей в личном кабинете*/

function clear_primary_pass(){
    var primary_pass = document.getElementById('primary_pass');
    primary_pass.autocomplete = "new-password";
}

clear_primary_pass();