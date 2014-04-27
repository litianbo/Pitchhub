var counter = 2;
var limit = 5;

function addInput(divName){

    var schooldiv = document.createElement('input');
    var majordiv = document.createElement('input');
    var degreediv = document.createElement('input');
    var yeardiv = document.createElement('input');

    var x =  counter.toString();

    var a = new String("school");
    var b = new String("major");
    var c = new String("degree");
    var d = new String("year");


    schooldiv.type = 'text';
    schooldiv.id = 'auto' + x;
    schooldiv.className = 'form-control';
    schooldiv.setAttribute('style', 'float:left; width: 300px; margin-right: 5px');
    schooldiv.setAttribute('placeholder', 'School');
    schooldiv.setAttribute('name', a+x);

    majordiv.type = 'text';
    majordiv.className = 'form-control';
    majordiv.setAttribute('style', 'float:left; width: 220px; margin-right: 5px');
    majordiv.setAttribute('placeholder', 'Major');
    majordiv.setAttribute('name', b+x);

    degreediv.type = 'text';
    degreediv.className = 'form-control';
    degreediv.setAttribute('style', 'float:left; width: 100px; margin-right: 5px');
    degreediv.setAttribute('placeholder', 'Degree');
    degreediv.setAttribute('name', c+x);

    yeardiv.type = 'text';
    yeardiv.className = 'form-control';
    yeardiv.setAttribute('style', 'float:left; width: 100px; margin-right: 5px');
    yeardiv.setAttribute('placeholder', 'Year');
    yeardiv.setAttribute('name', d+x);
    /*

       var schoolINPUT = "<br/> <input type='text' id = 'auto" + x + "'" +  " class='form-control' style='float:left; width: 300px; margin-right: 5px' placeholder='School' name=" + a + x + " > ";

       var majorINPUT =  " <input type='text'  class='form-control' style='float:left; width: 100px; margin-right: 5px' placeholder='Degree ' name=" + b + x + "> ";


       var degreeINPUT =  " <input type='text'  class='form-control' style='float:left; width: 220px; margin-right: 5px' placeholder='Major' name=" + c + x + "> ";



       var yearINPUT =  " <input type='text'  class='form-control' style='float:left; width: 100px; margin-right: 5px' placeholder='Year' name=" + d + x + ">";

       schooldiv.innerHTML = schoolINPUT;
       majordiv.innerHTML = majorINPUT;
       degreediv.innerHTML =  degreeINPUT;
       yeardiv.innerHTML = yearINPUT;
       */

    document.getElementById(divName).appendChild(document.createElement('br'));
    document.getElementById(divName).appendChild(document.createElement('br'));
    document.getElementById(divName).appendChild(schooldiv);
    document.getElementById(divName).appendChild(majordiv);
    document.getElementById(divName).appendChild(degreediv);
    document.getElementById(divName).appendChild(yeardiv);
    counter++;
    if (counter > limit)  {
        var button = document.getElementById('addButton');
        button.parentNode.removeChild(button);
    }
}

