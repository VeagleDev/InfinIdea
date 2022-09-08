function typeEffect(element, speed) {
    element.style.display = "inline-block";
    var text = element.innerHTML;
    element.innerHTML = "";
    
    var i = 0;
    var timer = setInterval(function() {
      if (i < text.length) {
        element.append(text.charAt(i));
        i++;
      } else {
        clearInterval(timer);
      }
    }, speed);
}

var codeDisplayViewport = true

get_check_site()
check_site(true)

function check_site(isSiteAlreadyStarted){
    sessionStorage.setItem('isSiteAlreadyStarted', isSiteAlreadyStarted)
}

function get_check_site () {
  if (sessionStorage.getItem('isSiteAlreadyStarted') != null) {
    codeDisplayViewport = false
    for(var i = 0; i < document.getElementsByClassName("o").length; i++) {
      document.getElementsByClassName("o")[i].style.display = "inline-block"
    }
  }else {
    codeDisplayViewport = true
    document.getElementsByClassName("welcom-display")[0].style.opacity = "0"
  }
}

window.addEventListener("scroll", effect);

function effect() {
    if((window.pageYOffset * 4) >= document.getElementsByClassName("welcom-display")[0].offsetTop) {
        if(codeDisplayViewport === true) {
          var speed = 75;
          var h1 = document.getElementsByClassName("o")[0];
          var p = document.getElementsByClassName("o");
  
          var delay = h1.innerHTML.length * speed + speed;
          
          typeEffect(h1, speed); 
          
          setTimeout(function(){
              typeEffect(p[1], speed);
              typeEffect(p[2], speed);
              typeEffect(p[3], speed);
              typeEffect(p[4], speed);
              typeEffect(p[5], speed);
              typeEffect(p[6], speed);
              typeEffect(p[7], speed);
              typeEffect(p[8], speed);
              typeEffect(p[9], speed);
              typeEffect(p[10], speed);
              typeEffect(p[11], speed);
          }, delay);

          document.getElementsByClassName("welcom-display")[0].style.animation = "welcomCodeDisplay 1500ms forwards"
  
          codeDisplayViewport = false
        }
    }
}