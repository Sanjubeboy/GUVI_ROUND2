const form = document.querySelector(".right form");
const continueBtn = form.querySelector(".button input");
const email = form.querySelector(".email input");

form.onsubmit = (e) =>
{
    console.log("submitted");
    e.preventDefault();                 //prevent the form from submitting
}

continueBtn.onclick = () =>
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/register.php",  true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status == 200){
            let data = xhr.response;
            
            let comp =data.substr(0,7);

            let name = data.substr(7);

            if(comp == "success"){
                console.log("signed up");
                localStorage.setItem("name",name);
                localStorage.setItem("email",email.value);
                location.href = "profile.html";
            }else{
                alert(data);
                console.log(data);
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}