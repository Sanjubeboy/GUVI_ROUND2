const form = document.querySelector(".right form");
const continueBtn = form.querySelector(".button input");
const email = form.querySelector(".email input");

form.onsubmit = (e) =>
{
    console.log("submitted");
    e.preventDefault();           
}

console.log("hello");

continueBtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php",  true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status == 200){
            let data = xhr.response;
            let comp =data.substr(0,7);

            let name = data.substr(7);

            if(comp == "success"){
                console.log(comp);
                console.log(email.value);
                localStorage.setItem("email",email.value);
                localStorage.setItem("name",name);
                location.href = "profile.html";
                // localStorage.setItem("isLoggedIn", <?php ?>);
            }else{
                alert(data);
                console.log(data);
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
