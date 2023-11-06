var button = document.getElementById("phonebutton")
var x = document.getElementById("links");

button.addEventListener('click',menufunction)
var img = document.querySelectorAll('.fileimg')
// skab fold ud memnu
function menufunction() {
    if (x.style.display === "flex") {
      x.style.display = "none";
    } else {
      x.style.display = "flex";
    }
  }

window.addEventListener("resize",screensize)
function screensize(){
  var width = window.innerWidth;
  if(width > 720){
    x.style.display = "flex";
  }else if(width <= 720){
    x.style.display = "none";
  }
}


// img modal
function imgfuntion(){
    if (img.length > 0){
        img.forEach(single_img => {
        single_img.addEventListener("click", modal)
    });
    }else{
        return
    }
}
imgfuntion()

function modal(){
    let overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.prepend(overlay);

    let closeBtn = document.createElement('button');
    closeBtn.innerText = "X";
    overlay.append(closeBtn);
    closeBtn.addEventListener('click', (e) => {
        e.target.parentNode.parentNode.removeChild(e.target.parentNode);
    })

    let imgcontainer = document.createElement('div')
    imgcontainer.classList.add('imgcontainer');
    overlay.append(imgcontainer)

    let imgscale = document.createElement('img');
    imgscale.classList.add('largeimg');
    imgscale.src = this.src
    imgcontainer.append(imgscale)
}