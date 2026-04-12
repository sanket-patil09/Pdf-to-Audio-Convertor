(function () {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  // let selectHeader = select('#header')
  // if (selectHeader) {
  //   const headerScrolled = () => {
  //     if (window.scrollY > 100) {
  //       selectHeader.classList.add('header-scrolled')
  //     } else {
  //       selectHeader.classList.remove('header-scrolled')
  //     }
  //   }
  //   window.addEventListener('load', headerScrolled)
  //   onscroll(document, headerScrolled)
  // }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }


  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function (e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function (e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scroll with offset on links with a class name .scrollto
   */
  on('click', '.scrollto', function (e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with offset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader Remove
   */
  const RemovePreloader = () => {
    let preloader = select('#preloader');
    if (preloader) {
      window.addEventListener('load', () => {
        if (document.getElementById("header")) {
          preloader.remove()
        }
      });
    }
  }
  RemovePreloader();


  /**
   * Testimonials slider
   */
  new Swiper('.testimonials-slider', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });

  /**
   * Animation on scroll
   */
  window.addEventListener('load', () => {
    AOS.init({
      duration: 1000,
      easing: "ease-in-out",
      once: true,
      mirror: true
    });
  });

})()


/* 
 * gsap for cursor motion
 */
const mouseMove = () =>{
  document.getElementById("page1").addEventListener("mouseenter",function(dets){
    gsap.to("#cursor, #cursor-blur",{
      scale:1,
      opacity:1,
      left:dets.x-5,
      top:dets.y-5
    })
  })
  document.getElementById("page1").addEventListener("mousemove",function(dets){
    gsap.to("#cursor",{
      left:dets.x-5,
      top:dets.y-5
    })
    gsap.to("#cursor-blur",{
      left:dets.x-115,
      top:dets.y-115
    })
  })
  document.getElementById("page1").addEventListener("mouseleave",function(dets){
    gsap.to("#cursor, #cursor-blur",{
      scale:0,
      opacity:0
    })
  })

  document.getElementById("page2").addEventListener("mouseenter",function(dets){
    gsap.to("#main-cursor" , {
      scale:1,
      opacity:1,
      left:dets.x-15,
      top:dets.y-10
    })
  })
  document.getElementById("page2").addEventListener("mousemove",function(dets){
    gsap.to("#main-cursor",{
      left:dets.x-15,
      top:dets.y-10
    })
  })
  document.getElementById("page2").addEventListener("mouseleave",function(){
    gsap.to("#main-cursor" , {
      scale:0,
      opacity:0
    })
  })

  document.getElementById("page3").addEventListener("mouseenter",function(){
    gsap.to("#main-cursor" , {
      scale:1,
      opacity:1
    })
  })
  document.getElementById("page3").addEventListener("mousemove",function(dets){
    gsap.to("#main-cursor",{
      left:dets.x-15,
      top:dets.y-10
    })
  })
  document.getElementById("page3").addEventListener("mouseleave",function(dets){
    gsap.to("#main-cursor",{
      scale:0,
      opacity:0
    })
  })
}
mouseMove();


/* 
  change background color on scroll
*/
gsap.to("#main", {
  backgroundColor: "#fff",
  scrollTrigger: {
    trigger: "#main",
    scroller: "body",
    start: "top -40%",
    end: "top -100%",
    // markers:true
    scrub: 2
  }
})

/* 
 * gsap for changing background color
 */
gsap.to("#header", {
  backgroundColor: "rgba(0, 0, 0, 0.8)",
  scrollTrigger: {
    trigger: "#header",
    scroller: "body",
    start: "top -30%",
    end: "top -70%",
    scrub: 1
  }
})

/* 
 * gsap for main homepage video h1 text
 */
gsap.to("#main #page1 #heading-container #head-text-convert", {
  left: "-5vw",
  scrollTrigger: {
    trigger: "#main",
    scroller: "body",
    start: "top -10%",
    end: "top -60%",
    scrub: 2
  }
})
gsap.to("#main #page1 #heading-container #head-text-your", {
  right: "-5vw",
  scrollTrigger: {
    trigger: "#main",
    scroller: "body",
    start: "top -10%",
    end: "top -60%",
    scrub: 2
  }
})
gsap.to("#main #page1 #head-text-pdf-to", {
  color: "#fff0",
  fontSize: "20px",
  scrollTrigger: {
    trigger: "#main",
    scroller: "body",
    start: "top -20%",
    end: "top -50%",
    scrub: 2
  }
})

/* 
 * function for typing animation for pdf to audio , pdf to docx text
 */

const TypeAnimation = () => {
  let typed = new Typed(".auto-type", {
    strings: ["AUDIO", "JPG"],
    typeSpeed: 150,
    backSpeed: 50,
    loop: true,
  })
}
TypeAnimation();

