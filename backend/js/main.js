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

      el++        
      element.style.display = "flex"
      if(el !== document.querySelectorAll(".o").length)
      typeEffect(document.getElementsByClassName("o")[el], 20)

      if(element.classList.contains("last-txt")) {
        element.innerHTML = text + '<p class="pointer">_</p>'
      }
    }
  }, speed);
}

var el = 0

var codeDisplayViewport = true

// window.addEventListener("scroll", effect);

// function effect() {
//     if((window.pageYOffset * 10) >= document.getElementsByClassName("welcom-display")[0].offsetTop) {
//         if(codeDisplayViewport === true) {
//           typeEffect(document.getElementsByClassName("o")[el], 20)
//           codeDisplayViewport = false
//         }
//     }
// }

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if(entry.isIntersecting) {
      typeEffect(entry.target, 20)
      typeEffect(entry.target + 1, 20)
    }
  })
})

const hiddenElements = document.querySelectorAll(".o")
hiddenElements.forEach((el) => observer.observe(el))