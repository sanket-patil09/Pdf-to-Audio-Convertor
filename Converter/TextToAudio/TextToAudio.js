function TextToAudio(){
    let speech = new SpeechSynthesisUtterance();
    let voices = [];
    let voiceSelect = document.querySelector("#select-voice");
    let pauseBtn = document.querySelector("#pauseSynthesis");

    window.speechSynthesis.onvoiceschanged = () =>{
        voices = window.speechSynthesis.getVoices();
        speech.voice = voices[0];

        voices.forEach((voice,i) => (voiceSelect.options[i] = new Option(voice.name,i)));
    };

    voiceSelect.addEventListener("change",()=>{
        speech.voice = voices[voiceSelect.value];
    })

    document.querySelector("#speak-btn").addEventListener('click', ()=>{
        speech.text = document.querySelector("textarea").value;
        window.speechSynthesis.speak(speech);
    });
    pauseBtn.addEventListener("click", () => {
        window.speechSynthesis.pause();
    })
    resumeBtn.addEventListener("click", () => {
        window.speechSynthesis.resume();
    })
}
TextToAudio();

/* 
    change background color on scroll
*/
gsap.to("main", {
    backgroundColor: "#000",
    color: "#fff",
    scrollTrigger: {
        trigger: "main",
        scroller: "body",
        start: "top -30%",
        end: "top -80%",
        scrub: 2
    }
})
/* 
    change navbar background color on scroll
*/
gsap.to("#header", {
    backgroundColor: "rgba(0, 0, 0, 0.8)",
    scrollTrigger: {
        trigger: "#header",
        scroller: "body",
        start: "top 5%",
        end: "top -70%",
        scrub: 1
    }
})


function CursorMoving() {
    document.getElementById("text-to-audio-page1").addEventListener("mouseenter", function (dets) {
        gsap.to("#main-cursor", {
            scale: 1,
            opacity: 1,
            left: dets.x - 15,
            top: dets.y - 10
        })
    })
    document.addEventListener("mousemove", function (dets) {
        gsap.to("#main-cursor", {
            left: dets.x - 15,
            top: dets.y - 10
        })
    })
    document.getElementById("text-to-audio-page1").addEventListener("mouseleave", function () {
        gsap.to("#main-cursor", {
            scale: 0,
            opacity: 0
        })
    })


    document.getElementById("text-to-audio-section").addEventListener("mouseenter", function () {
        gsap.to("#main-cursor", {
            scale: 1,
            opacity: 1
        })
    })
    // document.getElementById(text-to-audio-section").addEventListener("mousemove", function (dets) {
    //     gsap.to("#main-cursor", {
    //         left: dets.x - 15,
    //         top: dets.y - 10
    //     })
    // })

    document.getElementById("text-to-audio-section").addEventListener("mouseleave", function () {
        gsap.to("#main-cursor", {
            scale: 0,
            opacity: 0
        })
    })
}
CursorMoving();
