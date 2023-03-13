
function myFunction() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");
  
    if (dots.style.display === "none") {
      dots.style.display = "inline";
      btnText.value = "Read more";
      moreText.style.display = "none";
    } else {
      dots.style.display = "none";
      btnText.value = "Read less";
      moreText.style.display = "inline";
    }
  }

function check()
{
    localStorage.clear();
    location.href="login.html";
    
}


function preventBack() { window.history.forward(); }  
setTimeout("preventBack()", 0);  
window.onunload = function () { null };


const form = document.querySelector(".myLeftCtn form");
const continueBtn = form.querySelector(".button input");
const print = document.querySelector(".myRightCtn .box header");
const hiddenInput = form.querySelector(".hidden input");

const name = localStorage.getItem('name');
const email = localStorage.getItem("email");
console.log(email);
if(localStorage.getItem('name') === null)
{
    location.href = "login.html";
}
else{
    hiddenInput.value = email;
    // console.log(hiddenInput.value);
}


if(name != null)
{
    print.innerHTML = "Welcome " + name + "!!";
}
// else if(email != null)
// {
//     const emailname = email.split('@')[0];
//     print.innerHTML = "Hello " + emailname;
// }
else{
    print.innerHTML = "Hello " + "User";
}

form.onsubmit = (e) =>
{ 
    e.preventDefault();           
}   

continueBtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/profile.php",  true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status == 200){
            let data = xhr.response;
            if(data == "success")
            {
                console.log(data);
                alert("Details updated in Mongodb!");
            }else{
                alert(data);
                console.log(data);
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
