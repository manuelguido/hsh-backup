//Funcion de Switch del perfil/panel
function menuSwitch(n) {
    var subItems = document.getElementsByClassName('subItem');
    var menuItems = document.getElementsByClassName('menuItem');
    var profileTitle = document.getElementById('profile-title');
    
    for(var i = 0; i < subItems.length; i++) {
        subItems[i].style.display = 'none';
        menuItems[i].style.background = '#fff';
        menuItems[i].style.color = '#121212';
    }
    profileTitle.innerHTML = menuItems[n].innerHTML;
    subItems[n].style.display = 'block';
    menuItems[n].style.background = '#ddd';
    menuItems[n].style.color = '#000';
}

//Funcion de Switch Generica
function elementSwitch(cant, subItem) {
    var subItems = document.getElementsByClassName(subItem);
    
    for(var i = 0; i < subItems.length; i++) {
        subItems[i].style.display = 'none';
    }
    subItems[cant].style.display = 'block';
}

//Funcion de Switch de galería
function gallerySwitch(cant) {
    var subItems = document.getElementsByClassName('property-img');
    var subItems2 = document.getElementsByClassName('property-subimage');

    for(var i = 0; i < subItems.length; i++) {
        subItems[i].style.display = 'none';
        subItems2[i].style.opacity = '0.6';
    }
    subItems[cant].style.display = 'block';
    subItems2[cant].style.opacity = '1.0';
}

//
function saveInfo() {
    var x = document.getElementById("saveInfo");
    var y = 'Cancelar <i class="fas fa-times"></i>'
    var z = 'Editar Información <i class="far fa-edit"></i>'
    var inputs = document.getElementsByClassName('personal-input');
    
    if (document.getElementById("editInfo").innerHTML == y) {
        x.style.display = "none";
        document.getElementById("editInfo").innerHTML = z;
        for(var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = true;
        }
    } else {
        x.style.display = "inline";
        document.getElementById("editInfo").innerHTML = y;
        for(var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
        }
    }
}

//Credit cards
$(document).ready(function(){
    $("#showCreditForm").click(function(){
        $("#debitForm").hide();
        $("#creditForm").show();
    });
    $("#showDebitForm").click(function(){
        $("#creditForm").hide();
        $("#debitForm").show();
    });
});

//Image switch
$(document).ready(function(){
    $("#showCreditForm").click(function(){
        $("#debitForm").hide();
        $("#creditForm").show();
    });
    $("#showDebitForm").click(function(){
        $("#creditForm").hide();
        $("#debitForm").show();
    });
});

//Simple modal
function showLogout() {
    document.getElementById("modal").style.display = 'block';
}
function hideLogout() {
    document.getElementById("modal").style.display = 'none';
}

//Admin images handler
$(document).ready( function() {
    $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
    
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp1").change(function(){
        readURL(this);
    });
});

function date() {
    var input = document.getElementById("week_begin_date").value;
    var date = new Date(input).getUTCDay();
    
    var weekday = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    
    document.getElementById('check_sunday').value = weekday[date];
}

function menuSwitch(n) {
    var subItems = document.getElementsByClassName('subItem');
    var menuItems = document.getElementsByClassName('menuItem');
    var profileTitle = document.getElementById('profile-title');
    
    for(var i = 0; i < subItems.length; i++) {
        subItems[i].style.display = 'none';
        menuItems[i].style.background = '#fff';
        menuItems[i].style.color = '#121212';
    }
    profileTitle.innerHTML = menuItems[n].innerHTML;
    subItems[n].style.display = 'block';
    menuItems[n].style.background = '#ddd';
    menuItems[n].style.color = '#000';
}

function addWeek(a,b,cant) {
    var dt = new Date( document.getElementById(a).value);

    dt.setDate( dt.getDate() + cant );
    document.getElementById(b).value = dt.toISOString().substring(0, 10);
    
}

function getDayOfWeek(date) {
    var dayOfWeek = new Date(date).getDay();    
    return isNaN(dayOfWeek) ? null : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][dayOfWeek];
}

function myFunction() {
    var subItems = document.getElementsByClassName('localidad_select');
    var x = document.getElementById("provincia").value;

    for(var i = 0; i < subItems.length; i++) {
        subItems[i].style.display = 'none';
        subItems[i].removeAttribute("name", "city");
        subItems[i].removeAttribute("id", "city");
    }
    subItems[x-1].style.display = 'block';
    subItems[x-1].setAttribute("name", "city");
    subItems[x-1].setAttribute("id", "city");
}

function semanaSubasta() {
    var subItems = document.getElementsByClassName('semanas_subasta_select');
    var x = document.getElementById("semana_subasta_select").value;

    for(var i = 0; i < subItems.length; i++) {
        subItems[i].style.display = 'none';
        //subItems[i].removeAttribute("name", "city");
        //subItems[i].removeAttribute("id", "city");
    }
    subItems[x-1].style.display = 'block';
    //subItems[x-1].setAttribute("name", "city");
    //subItems[x-1].setAttribute("id", "city");
}