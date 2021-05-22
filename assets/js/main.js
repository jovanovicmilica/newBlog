$(document).ready(function(){

    


    var url=location.href;

    
    if(url.indexOf("admintemplate")==-1){
        dohvatiMeni();
    }


    if(url.indexOf("index.php")!=-1){
       $("#btnAnketa").click(glasaj)
    }
    if(url.indexOf("post.php")!=-1){
       dohvatiKomentare()
       dohvatiBrojKomentara()
       dohvatiBrojLajkova()
       $("#btnComment").click(postComment)
       $("#prazno").click(like)
    }
    if(url.indexOf("login.php")!=-1){
       $("#btnLogin").click(uloguj)
    }
    if(url.indexOf("register.php")!=-1){
       $("#btnRegister").click(registruj)
    }
    if(url.indexOf("contact.php")!=-1){
       $("#btnMessage").click(sendMessage)
    }
    if(url.indexOf("admintemplate/dist/index.php")!=-1){
        $("#rezultatiAnkete").click(dohvatiRezultate)
        $("#dohvatiPostove").click(dohvatiPostove)
        $("#dodajPost").click(dodajPostForma)
        $("#dohvatiKategorije").click(dohvatiKategorije)
        $("#dodajKategoriju").click(dodajKategoriju)
        $("#dohvatiSponzore").click(dohvatiSponzore)
        $("#dodajSponzora").click(dodajSponzora)
        $("#dohvatiKorisnike").click(dohvatiKorisnike)
        $("#dohvatiPoruke").click(dohvatiPoruke)
        $("#dohvatiKomentare").click(dohvatiSveKomentare)
    }
})

function dohvatiRezultate(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/dohvatiAnketuAdmin.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            ispisRezultata(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function ispisRezultata(data){
    var ispis="<div class='col-8 mx-auto'>"
    ispis+=`<h2>${data.pitanje.pitanje}</h2>`
    for(let d of data.odgovori){
        ispis+=`<p>${d.tekstOdgovora} ${d.broj}%</p>`
    }
    if(data.aktivna==0){
        ispis+=`<a href="#" id="aktiviraj">Activate</a>`
    }
    else{
        ispis+=`<a href="#" id="deaktiviraj">Deactivate</a>`
    }
    ispis+="</div>"
    $("#content").html(ispis)
    $("#naslov").html("Questionaire")
    $("#aktiviraj").click(aktiviraj)
    $("#deaktiviraj").click(deaktiviraj)
}
function deaktiviraj(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/deaktiviraj.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            dohvatiRezultate(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function aktiviraj(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/aktiviraj.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            dohvatiRezultate(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dohvatiPostove(e){
    e.preventDefault()
        $.ajax({
            url:'../../model/postoviAdmin.php',
            method:"GET",
            dataType:"json",
            data:{
            },
            success:function(data){
                ispisPostovaAdmin(data)
            },
            error:function(xhr){
                $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
            }
        })
}
function ispisPostovaAdmin(data){
    var ispis="<table class='mx-auto table text-center'>"
    ispis+=`<tr><th>Image</th><th>Title</th><th>Likes</th><th>Comments</th><th>Update</th><th>Delete</th></tr>`
    for(let d of data){
        ispis+=`<tr>
            <td><img class="img-fluid" src="../../assets/images/${d.slikasrc}"/></td>
            <td>${d.naslov}</td>
            <td>${d.brojLajkova}</td>
            <td>${d.brojKomentara}</td>
            <td><a href="#" data-id="${d.idPosta}" class="updatePost">Update</a></td>
            <td><a href="#" data-id="${d.idPosta}" class="deletePost">Delete</a></td>
        </tr>`
    }

    ispis+="</table>"
    $("#content").html(ispis)
    $("#naslov").html("All posts")
    $(".deletePost").click(obrisiPost)
    $(".updatePost").click(updatePost)
}
function obrisiPost(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/obrisiPost.php',
        method:"POST",
        dataType:"json",
        data:{
            "dugme":true,
            "id":id
        },
        success:function(data){
            dohvatiPostove(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function updatePost(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/dohvatiPostAdmin.php',
        method:"GET",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            popuniFormu(data['kategorija'],data['post'])
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dodajPostForma(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/dohvatiKategorijeAdmin.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            popuniFormu(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function popuniFormu(data,dataUpdate=null){
    var ispis=''
    ispis+=`<form enctype="multipart/form-data>`

    ispis+=`
        <div class="col-xs-12 mx-auto mt-2">
            <label for="title">Title</label>
            <input class="form-control" type="text" id="title"/>
        </div>
        
        <div class="col-xs-12 mx-auto mt-2">
            <label for="image">Image</label>
            <input type="file" id="image"/>
        </div>
        
        <div class="col-xs-12 mx-auto mt-2">
            <label for="text">Text</label>
            <textarea class="form-control" id="text"></textarea>
        </div>

        <div class="col-xs-12 mx-auto mt-2">
            <p>Category</p>
            <br/>
        `
        for(let d of data){
            ispis+=`<input type="radio" class="ml-2" value=${d.idKategorije} name="rbCategory"`
            if(dataUpdate){
                if(dataUpdate.idKategorije==d.idKategorije){
                    ispis+=`checked='true'`
                }
            }
            ispis+=`/>${d.naziv}`
        }
        ispis+=`
        </div>
        
        <div class="col-xs-12 mx-auto mt-2">`
            
            if(dataUpdate){
                ispis+=`<input type="hidden" id="idPosta" value="${dataUpdate['idPosta']}">`
                ispis+=`<input type="button" id="editPost" value="Edit post" class="btn btn-primary"/>`
            }
            else{
                ispis+=`<input type="button" id="addPost" value="Add post" class="btn btn-primary"/>`
            }
        ispis+=`</div>
    `

    ispis+=`<form><p id="porukaPost"></p>`
    if(!dataUpdate){
        $("#naslov").html("Add post")
    }
    else{
        $("#naslov").html("Edit post")
    }
    $("#content").html(ispis)
    if(dataUpdate){
        $("#title").val(dataUpdate.naslov)
        $("#text").val(dataUpdate.tekst)
    }
    $("#addPost").click(addPost)
    $("#editPost").click(editPost)
}
function addPost(){
    var naslov=document.getElementById("title").value
    var tekst=document.getElementById("text").value
    var kategorija=document.getElementsByName("rbCategory")
    var izbor=null
    for(let i=0;i<kategorija.length;i++){
        if(kategorija[i].checked){
            izbor=kategorija[i].value
            break
        }
    }
    var slika=document.getElementById("image").files[0]

    var podaciZaSlanje= new FormData()

    podaciZaSlanje.append("naslov",naslov)
    podaciZaSlanje.append("tekst",tekst)
    podaciZaSlanje.append("kategorija",izbor)
    podaciZaSlanje.append("slika",slika)
    podaciZaSlanje.append("dugme",true)

    $.ajax({
        url:'../../model/dodajPost.php',
        method:"POST",
        processData:false,
        contentType:false,
        dataType:"json",
        data:podaciZaSlanje,
        success:function(data){
            if(data=="Post successfully added"){
                $("input[type='text']").val("")
                $("textarea").val("")
            }
            $("#porukaPost").html(data)
        },
        error:function(xhr){
            $("#porukaPost").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
    
}
function editPost(){
    var naslov=document.getElementById("title").value
    var tekst=document.getElementById("text").value
    var idPosta=document.getElementById("idPosta").value
    var kategorija=document.getElementsByName("rbCategory")
    var izbor=null
    for(let i=0;i<kategorija.length;i++){
        if(kategorija[i].checked){
            izbor=kategorija[i].value
            break
        }
    }
    var slika=document.getElementById("image").files[0]

    var podaciZaSlanje= new FormData()

    podaciZaSlanje.append("naslov",naslov)
    podaciZaSlanje.append("tekst",tekst)
    podaciZaSlanje.append("kategorija",izbor)
    podaciZaSlanje.append("slika",slika)
    podaciZaSlanje.append("idPosta",idPosta)
    podaciZaSlanje.append("dugme",true)

    $.ajax({
        url:'../../model/updatePost.php',
        method:"POST",
        processData:false,
        contentType:false,
        dataType:"json",
        data:podaciZaSlanje,
        success:function(data){
            $("#porukaPost").html(data)
        },
        error:function(xhr){
            $("#porukaPost").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dohvatiKategorije(e){
    $.ajax({
        url:'../../model/dohvatiKategorijeAdmin.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            ispisKategorija(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function ispisKategorija(data){
    var ispis="<table class='mx-auto table text-center'>"
    ispis+=`<tr><th>Image</th><th>Name</th><th>Update</th><th>Delete</th></tr>`
    for(let d of data){
        ispis+=`
        <tr>
            <td><img src="../../assets/images/${d.slikasrc}"/></td>
            <td>${d.naziv}</td>
            <td><a href="#" class="updateCategory" data-id="${d.idKategorije}">Update</a></td>
            <td><a href="#" class="deleteCategory" data-id="${d.idKategorije}">Delete</a></td>
        </tr>
        `
    }

    ispis+="</table>"
    $("#content").html(ispis)
    $("#naslov").html("All categories")
    $(".deleteCategory").click(obrisiKategoriju)
    $(".updateCategory").click(dohvatiKategoriju)

}
function dohvatiKategoriju(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/dohvatiKategoriju.php',
        method:"POST",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            formaKategorija(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function obrisiKategoriju(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/obrisiKategoriju.php',
        method:"POST",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            dohvatiKategorije(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dodajKategoriju(e){
    e.preventDefault()
    formaKategorija()
}
function formaKategorija(data){
    var ispis=``
    ispis+=`<form enctype="multipart/form-data>`

    ispis+=`
        <div class="col-xs-12 mx-auto mt-2">
            <label for="naziv">Name</label>
            <input class="form-control" type="text" id="naziv"/>
        </div>

        
        <div class="col-xs-12 mx-auto mt-2">
            <label for="image">Image</label>
            <input type="file" id="image"/>
        </div>
        
        <div class="col-xs-12 mx-auto mt-2">
        `
        
    if(data){
        ispis+=`<input type="hidden" id="idKategorije" value="${data.idKategorije}"/>`
        ispis+=`<input class="btn btn-primary" type="button" value="Edit category" id="updateCat"/>`
    }
    else{
        ispis+=`<input class="btn btn-primary" type="button" value="Add category" id="insertCat"/>`
    }
        
    ispis+=`</div><p id="porukaKategorija"></p></form>`
    $("#content").html(ispis)

    if(data){
        $("#naziv").val(data.naziv)
        $("#naslov").html("Edit category")
    }
    else{
        $("#naslov").html("Add category")
    }
    $("#insertCat").click(addCategory)
    $("#updateCat").click(updateCategoryAdmin)
}
function updateCategoryAdmin(){
    var naziv=document.getElementById("naziv").value
    var img=document.getElementById("image").files[0]
    var id=document.getElementById("idKategorije").value

    var podaciZaSlanje=new FormData()

    podaciZaSlanje.append("naslov",naziv)
    podaciZaSlanje.append("slika",img)
    podaciZaSlanje.append("idKategorije",id)
    $.ajax({
        url:'../../model/updateKategorije.php',
        method:"POST",
        dataType:"json",
        processData:false,
        contentType:false,
        data:podaciZaSlanje,
        success:function(data){
            $("#porukaKategorija").html(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function addCategory(){
    var naziv=document.getElementById("naziv").value
    var img=document.getElementById("image").files[0]

    var podaciZaSlanje=new FormData()

    podaciZaSlanje.append("naslov",naziv)
    podaciZaSlanje.append("slika",img)
    $.ajax({
        url:'../../model/insertKategorije.php',
        method:"POST",
        dataType:"json",
        processData:false,
        contentType:false,
        data:podaciZaSlanje,
        success:function(data){
            $("#porukaKategorija").html(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dohvatiSponzore(e){
    $.ajax({
        url:'../../model/dohvatiSponzoreAdmin.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            ispisSponzora(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function ispisSponzora(data){
    var ispis="<table class='mx-auto table text-center'>"
    ispis+=`<tr><th>Name</th><th>Update</th><th>Delete</th></tr>`
    for(let d of data){
        ispis+=`
        <tr>
            <td>${d.naziv}</td>
            <td><a href="#" class="updateSponsor" data-id="${d.idSponzor}">Update</a></td>
            <td><a href="#" class="deleteSponsor" data-id="${d.idSponzor}">Delete</a></td>
        </tr>
        `
    }

    ispis+="</table>"
    $("#content").html(ispis)
    $("#naslov").html("All sponsors")
    $(".deleteSponsor").click(obrisiSponzora)
    $(".updateSponsor").click(dohvatiSponzoraUpdate)
}
function dohvatiSponzoraUpdate(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/dohvatiSponzora.php',
        method:"POST",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            formaSponzor(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function obrisiSponzora(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/obrisiSponzora.php',
        method:"POST",
        dataType:"json",
        data:{
            "dugme":true,
            "id":id
        },
        success:function(data){
            dohvatiSponzore(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dodajSponzora(e){
    e.preventDefault()
    formaSponzor()
}

function formaSponzor(data=null){
    var ispis=``
    ispis+=`<form enctype="multipart/form-data>`

    ispis+=`
        <div class="col-xs-12 mx-auto mt-2">
            <label for="name">Name</label>
            <input class="form-control" type="text" id="name"/>
        </div>
        
        <div class="col-xs-12 mx-auto mt-2">
        `
        
    if(data){
        ispis+=`<input type="hidden" id="idSponzor" value="${data.idSponzor}"/>`
        ispis+=`<input class="btn btn-primary" type="button" value="Edit sponsor" id="updateSponsor"/>`
    }
    else{
        ispis+=`<input class="btn btn-primary" type="button" value="Add sponsor" id="insertSponsor"/>`
    }
        
    ispis+=`</div><p id="porukaSponzor"></p></form>`

    $("#content").html(ispis)
    if(data){
        $("#name").val(data.naziv)
        $("#naslov").html("Update sponsor")
    }
    else{
        $("#naslov").html("Add sponsor")
    }

    $("#insertSponsor").click(insertSponsor)
    $("#updateSponsor").click(editSponsor)

}
function editSponsor(){
    var name=$("#name").val()
    var id=$("#idSponzor").val()
    $.ajax({
        url:'../../model/editSponzora.php',
        method:"POST",
        dataType:"json",
        data:{
            "dugme":true,
            "id":id,
            "name":name
        },
        success:function(data){
            $("#porukaSponzor").html(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function insertSponsor(){
    var name=$("#name").val()
    $.ajax({
        url:'../../model/dodajSponzora.php',
        method:"POST",
        dataType:"json",
        data:{
            "dugme":true,
            "name":name
        },
        success:function(data){
            $("#porukaSponzor").html(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dohvatiKorisnike(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/dohvatiKorisnike.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            ispisKorisnika(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function ispisKorisnika(data){
    var ispis="<table class='mx-auto table text-center'>"
    ispis+=`<tr><th>First Name</th><th>Last Name</th><th>E-mail</th></tr>`
    for(let d of data){
        ispis+=`
        <tr>
            <td>${d.ime}</td>
            <td>${d.prezime}</td>
            <td>${d.email}</td>
        </tr>
        `
    }

    ispis+="</table>"
    $("#content").html(ispis)
    $("#naslov").html("All users")
}
function dohvatiSveKomentare(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/dohvatiKomentareAdmin.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            ispisKomentaraSvih(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function ispisKomentaraSvih(data){
    var ispis="<table class='mx-auto table text-center'>"
    ispis+=`<tr><th>Post Title</th><th>E-mail</th><th>Text</th><th>Delete</th></tr>`
    for(let d of data){
        ispis+=`
        <tr>
            <td>${d.naslov}</td>
            <td>${d.email}</td>
            <td>${d.tekst}</td>
            <td><a href="#" class="deleteComments" data-id="${d.idKomentar}">Delete</a></td>
        </tr>
        `
    }

    ispis+="</table>"
    $("#content").html(ispis)
    $("#naslov").html("All comments")
    $(".deleteComments").click(deleteComment)
}
function deleteComment(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/obrisiKomentar.php',
        method:"POST",
        dataType:"json",
        data:{
            "dugme":true,
            "id":id
        },
        success:function(data){
            dohvatiSveKomentare(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function dohvatiPoruke(e){
    e.preventDefault()
    $.ajax({
        url:'../../model/dohvatiPoruke.php',
        method:"GET",
        dataType:"json",
        data:{
        },
        success:function(data){
            ispisPoruka(data)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}
function ispisPoruka(data){
    var ispis="<table class='mx-auto table text-center'>"
    ispis+=`<tr><th>E-mail</th><th>Title</th><th>Text</th><th>Delete</th></tr>`
    for(let d of data){
        ispis+=`
        <tr>
        <td>${d.email}</td>
            <td>${d.naslov}</td>
            <td>${d.tekst}</td>
            <td><a data-id="${d.idPoruke}" href='#' class="deleteMessage">Delete</a></td>
        </tr>
        `
    }

    ispis+="</table>"
    $("#content").html(ispis)
    $("#naslov").html("All messages")

    $(".deleteMessage").click(obrisiPoruku)
}
function obrisiPoruku(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:'../../model/obrisiPoruku.php',
        method:"POST",
        dataType:"json",
        data:{
            "dugme":true,
            "id":id
        },
        success:function(data){
            dohvatiPoruke(e)
        },
        error:function(xhr){
            $("#content").html(`<h2>${JSON.parse(xhr.responseText)}</h2>`)
        }
    })
}

function sendMessage(){
    var email=$("#email").val()
    var title=$("#title").val()
    var message=$("#message").val()

    
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regNaslov=/^[\w\s]+$/;
    var greska=0;
    if(!regEmail.test(email)){
        $("#porukaEmail").html("E-mail format: pera.peric.5.20@ict.edu.rs or pera@gmail.com");
        greska++;
    }
    else{
        $("#porukaEmail").html("")
    }
    if(!regNaslov.test(title)){
        $("#porukaTitle").html("You have to write title");
        greska++;
    }
    else{
        $("#porukaTitle").html("")
    }
    message=message.split(" ")
    if(message.length<10){
        $("#porukaTekst").html("Message mus have 10 words minimum");
        greska++;
    }
    else{
        $("#porukaTekst").html("")
    }
    if(greska==0){
        $.ajax({
            url:'model/message.php',
            method:"POST",
            dataType:"json",
            data:{
                "mail":email,
                "poruka":message,
                "naslov":title,
                "btnMessage":true
            },
            success:function(data){
                $("#porukaPoruka").html(data)
                $("input[type='text']").val("")
                $("input[type='email']").val("")
                $("textarea").val("")

            },
            error:function(xhr){
                $("#porukaPoruka").html(JSON.parse(xhr.responseText))
            }
        })
    }
}



function dohvatiMeni(){
    $.ajax({
        url:"model/dohvatiMeni.php",
        method:"get",
        dataType:"json",
        success:function(data){
            ispisMeni(data)
        },
        error:function(xhr){
            $("nav").html(JSON.parse(xhr.responseText))
        }
    })
}

function ispisMeni(data){
    let ispis=''
    for (let d of data) {
        ispis+=`<li class="nav-item">
            <a class="text-light fw-bold fs-5 nav-link" href="${d.putanja}">${d.naziv}</a>
        </li>`
    }
    $("header nav ul").html(ispis)

}
function dohvatiBrojKomentara(){
    var id=$("#idPosta").val()
    $.ajax({
        url:"model/dohvatiBrojKomentara.php",
        method:"get",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            $("#brojKomentara").html(data.brojKomentara)
        },
        error:function(xhr){
            $("#brojKomentara").html(JSON.parse(xhr.responseText))
        }
    })
}
function dohvatiBrojLajkova(){
    var id=$("#idPosta").val()
    $.ajax({
        url:"model/dohvatiLajkove.php",
        method:"get",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            $("#brojLajkova").html(data['lajk'].brojLajkova)
            if(data['lajkovao']){
                $("#srce").html(`<i class="fas fa-heart text-danger" id="puno"></i>`)
                $("#puno").click(unlike)
            }
            else{
                $("#srce").html(`<i class="far fa-heart text-danger" id="prazno"></i>`)
                $("#prazno").click(like)
            }
            
        },
        error:function(xhr){
            $("#brojLajkova").html(JSON.parse(xhr.responseText))
        }
    })

}

function unlike(e){
    e.preventDefault()
    var id=$("#idPosta").val()
    $.ajax({
        url:"model/unlike.php",
        method:"post",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            dohvatiBrojLajkova()
        },
        error:function(xhr){
            $("#brojLajkova").html(JSON.parse(xhr.responseText))
        }
    })
}

function like(e){
    e.preventDefault()
    var id=$("#idPosta").val()
    $.ajax({
        url:"model/like.php",
        method:"post",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            dohvatiBrojLajkova()
        },
        error:function(xhr){
            $("#brojLajkova").html(JSON.parse(xhr.responseText))
        }
    })
}

function postComment(){
    var id=$("#idPosta").val()
    var text=$("#commentText").val()


     
    text=text.split(" ")
    if(text.length<5){
        $("#greskaComm").html("Comment must have 5 words minimum");
        return false
    }


    $.ajax({
        url:"model/dodajKomentar.php",
        method:"post",
        dataType:"json",
        data:{
            "id":id,
            "text":text,
            "btnComm":true
        },
        success:function(data){
            if(data.status==200){
                $("#greskaComm").html(data)
            }
            else{
                dohvatiKomentare()
                dohvatiBrojKomentara()
                $("textarea").val("")
                $("#greskaComm").html("")
            }
        },
        error:function(xhr){
            $("#greskaComm").html(JSON.parse(xhr.responseText))
        }
    })
}
function dohvatiKomentare(){
    var id=$("#idPosta").val()
    $.ajax({
        url:"model/dohvatiKomentare.php",
        method:"get",
        dataType:"json",
        data:{
            "id":id
        },
        success:function(data){
            if($.isArray(data)){
                ispisKomentara(data)
            }
            else{
                $("#komentari").html(data)
            }
        },
        error:function(xhr){
            $("#komentari").html(JSON.parse(xhr.responseText))
        }
    })
}

function ispisKomentara(data){
    let ispis=''
    for(let d of data){
        ispis+=`<div class="col-12 bg-light p-3 my-2 rounded">
        <div class="col-12 my-2 d-flex justify-content-between">
            <h3>${d.ime} ${d.prezime}</h3>
            <p>${d.datumKomentara}</p>
        </div>
        <div class="col-12 my-2">
            <p>${d.tekst}</p>
        </div>
    </div>`
    }

    $("#komentari").html(ispis)
}

function uloguj(){
    var email=$("#email").val()
    var pass=$("#pass").val()

    
    
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regPass=/^.{8,50}$/;

    
    if(!regEmail.test(email)){
        $("#porukaEmail").html("E-mail formats: petar.petrovic.17.16@ict.edu.rs or petar@gmail.com")
        return false
    }
    else{
        $("#porukaEmail").html("")
    }
    if(!regPass.test(pass)){
        $("#porukaPass").html("Password must be at least 8 characters long")
        return false
    }
    else{
        $("#porukaPass").html("")
    }
    $.ajax({
        url:'model/login.php',
        method:"POST",
        dataType:"json",
        data:{
            "mail":email,
            "pass":pass,
            "dugmeLog":true
        },
        success:function(data){
            if(data==201){
                location.href="index.php"
            }
            else{
                $("#porukaLog").html(data)
            }
        },
        error:function(xhr){
            $("#porukaLog").html(JSON.parse(xhr.responseText))
        }
    })
}

function registruj(){
    var ime=$("#fName").val()
    var prezime=$("#lName").val()
    var email=$("#email").val()
    var password=$("#pass").val()
    var passwordConfirm=$("#passConfirm").val()


    var regIme=/^[A-Z][a-z]{2,29}$/;
    var regPrezime=/^[A-Z][a-z]{2,39}$/;
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regPass=/^.{8,50}$/;

    
    
    var greske=0;
    if(!regIme.test(ime)){
        $("#porukaFName").html("First name must begin with a capital letter (maximum 30 characters)");
        greske++;
        
    }
    else{
        $("#porukaFName").html("");
    }
    if(!regPrezime.test(prezime)){
        $("#porukaLName").html("Last name must begin with a capital letter (maximum 40 characters)");
        greske++;
    }
    else{
        $("#porukaLName").html("");
    }
    if(!regEmail.test(email)){
        $("#porukaEmail").html("E-mail format: jelena@gmail.com or jelena.korugic@ict.edu.rs");
        greske++;
    }
    else{
        $("#porukaEmail").html("");
    }
    if(!regPass.test(password)){
        $("#porukaPass").html("Password must be at least 8 characters long");
        greske++;
    }
    else{
        $("#porukaPass").html("");
    }
    if(passwordConfirm!=password){
        $("#porukaPassConf").html("Passwords do not match");
        greske++;
    }
    else{
        $("#porukaPassConf").html("");
    }
    if(greske==0){
        
        $.ajax({
            url:"model/registracija.php",
            method:"post",
            dataType:"json",
            data:{
                "ime":ime,
                "prezime":prezime,
                "email":email,
                "pass":password,
                "passConf":passwordConfirm,
                "dugme":true
            },
            success:function(data){
                if(data=="There is already a user with that email address"){
                    $("#email").val("")
                    $("#porukaEmail").html(data)
                }
                else{
                    $("input[type='text']").val("")
                    $("input[type='password']").val("")
                    $("p").html("")
                    $("#porukaReg").html(data)
                }
            },
            error:function(xhr){
                if(xhr.status==422){
                    greske=JSON.parse(xhr.responseText)
                    console.log(greske)
                    if(greske.greskaime!=""){
                        $("#porukaFName").html(greske.greskaime)
                    }
                    if(greske.greskaime!=""){
                        $("#porukaLName").html(greske.greskaprezime)
                    }
                    if(greske.greskaime!=""){
                        $("#porukaEmail").html(greske.greskamail)
                    }
                    if(greske.greskaime!=""){
                        $("#porukaPass").html(greske.greskapss)
                    }
                    if(greske.greskaime!=""){
                        $("#porukaPassConf").html(greske.greskapassconf)
                    }
                }
                else{
                    $("#porukaReg").html(JSON.parse(xhr.responseText))
                }
            }
        })
    }
}

function glasaj(){
    var idAnketa=$("#idAnketa").val()
    var odgovor=$("input[name='rbAnketa']:checked").val()

    if(odgovor!=undefined){
        $.ajax({
            url:'model/anketaGlasaj.php',
            method:"POST",
            dataType:"json",
            data:{
                "odgovor":odgovor
            },
            success:function(data){
                $("#btnAnketa").attr("disabled",true)
            },
            error:function(xhr){
            }
        })
    }

}