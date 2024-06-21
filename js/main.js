const inputs = document.querySelectorAll(".input");

function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}
function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}

inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

let ver=document.getElementById("ver");
let clave=document.getElementById("clave")
let icono=document.getElementById("icono")
let con=true

ver.addEventListener("click", function(){
    if (con==true) {
        clave.type="text"
        icono.classList.add("fa-eye-slash")
        con=false
    } else {
        clave.type="password"
        icono.classList.remove("fa-eye-slash")
        con=true
    }
});

