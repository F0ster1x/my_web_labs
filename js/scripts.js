
function advertLoad(id) {
    let Req = new XMLHttpRequest();
    Req.onload = function () {
        const adverts = JSON.parse(this.responseText);
        for (let i = 0; i < adverts.length; i++) {
            document.getElementById("content").innerHTML += adverts[i];
        }
        advertCheck();
    }
    Req.open("get", "/PHPscripts/scriptLoad.php?id=" + id, true);
    Req.send();
}

function advertCheck() {
    const id = findLastId();
    let Req = new XMLHttpRequest();
    Req.onload = function () {
        const adverts = JSON.parse(this.responseText);
        if (adverts === 0) {
            document.getElementById("load_button").style.display = "none";
        }
    }
    Req.open("get", "/PHPscripts/advertCheck.php?id=" + id, true);
    Req.send();
}

function findLastId() {
    let parentDIV = document.getElementById("content");
    let idArray = [];
    for (let i = 0; i < parentDIV.children.length; i++) {
        idArray.push(parentDIV.children[i]['id']);
    }
    return Math.max.apply(null, idArray) + 1;

}
function registration() {
    let res = true;
    let registerForm = new FormData(document.getElementById('registration-form'));
    fetch('/PHPscripts/register.php', {
            method: 'POST',
            body: registerForm
        }
    )
        .then(response => response.json())
        .then((result) => {
            if (result.errors) {
                document.getElementById('regUL').innerText = "";
                for (let i = 0; i < result.errors.length; i++) {
                    let li = document.createElement("li");
                    li.innerText = result.errors[i];
                    document.getElementById('regUL').appendChild(li);
                }
            }
            else {
                window.location.href = '#';
                location.reload();
            }
        })
        .catch(error => console.log(error));
}

function authorization() {
    let registerForm = new FormData(document.getElementById('authorization-form'));
    fetch('/PHPscripts/authorization.php', {
            method: 'POST',
            body: registerForm
        }
    )
        .then(response => response.json())
        .then((result) => {
            console.log(result.errors);
            if (result.errors) {
                document.getElementById('logUL').innerText = "";
                for (let i = 0; i < result.errors.length; i++) {
                    let li = document.createElement("li");
                    li.innerText = result.errors[i];
                    document.getElementById('logUL').appendChild(li);
                }
            }
            else {
                window.location.href = '#';
                location.reload();
            }
        })
        .catch(error => console.log(error));

}

function sessionDelete(){
    let Req = new XMLHttpRequest();
    Req.onload = function () {
        location.reload();
    }
    Req.open("get", "/PHPscripts/sessionDelete.php", true);
    Req.send();
}

function loginCheck() {
    const LoginPass = document.querySelector('#loginPassword');
    const LoginEmail = document.querySelector('#loginEmail');

    function changeBackgroundLogin() {
        if (LoginPass.validity.patternMismatch || LoginEmail.validity.patternMismatch
            || LoginPass.validity.valueMissing || LoginEmail.validity.valueMissing
            || LoginPass.value.length < 7) {
            document.querySelector('#login_button').style.backgroundColor = 'darkgray';
        } else {
            document.querySelector('#login_button').style.backgroundColor = 'darkred';
        }
    }

    LoginPass.addEventListener('input', changeBackgroundLogin);
    LoginEmail.addEventListener('input', changeBackgroundLogin);
}

function registerCheck() {
    const pass = document.querySelector('#txtNewPassword');
    const nameBlock = document.querySelector('#RegistrationName');
    const email = document.querySelector('#email');
    const repeatPass = document.querySelector('#txtConfirmPassword');
    const tel = document.querySelector('#tel');
    const info = document.querySelector('#info');

    repeatPass.addEventListener('input', function () {
        if (!passCheck())
        {
            document.querySelector('#txtConfirmPassword').style.borderColor = 'red';
        }
        else
        {
            document.querySelector('#txtConfirmPassword').style.borderColor = 'green';
        }
    });

    function passCheck(){
        return pass.value === repeatPass.value;
    }

    function changeBackgroundRegistration() {
        if (pass.validity.patternMismatch || tel.validity.patternMismatch || email.validity.patternMismatch
            || nameBlock.validity.patternMismatch || repeatPass.validity.patternMismatch ||
            pass.validity.valueMissing || tel.validity.valueMissing || email.validity.valueMissing
            || nameBlock.validity.valueMissing || repeatPass.validity.valueMissing
            || !info.checked || !passCheck() || pass.value.length < 7 || repeatPass.value.length < 7) {
            document.querySelector('#button').style.backgroundColor = 'darkgray';
        } else {
            document.querySelector('#button').style.backgroundColor = 'darkred';
        }
    }

    pass.addEventListener('input', changeBackgroundRegistration);
    nameBlock.addEventListener('input', changeBackgroundRegistration);
    email.addEventListener('input', changeBackgroundRegistration);
    repeatPass.addEventListener('input', changeBackgroundRegistration);
    tel.addEventListener('input', changeBackgroundRegistration);
    info.addEventListener('input', changeBackgroundRegistration);
}