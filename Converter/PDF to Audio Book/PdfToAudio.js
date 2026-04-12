// pdf input taken
const dropContainer = document.getElementById("dropcontainer");
const fileInput = document.getElementById("pdfInput");
const preview = document.getElementById('preview');

dropContainer.addEventListener("dragover", e => {
    // prevent default to allow drop
    e.preventDefault();
}, false);

dropContainer.addEventListener("dragenter", () => {
    dropContainer.classList.add("drag-active");
});

dropContainer.addEventListener("dragleave", () => {
    dropContainer.classList.remove("drag-active");
});

dropContainer.addEventListener("drop", e => {
    e.preventDefault();
    dropContainer.classList.remove("drag-active");
    fileInput.files = e.dataTransfer.files;

    const file = e.dataTransfer.files[0];
    handleFile(file);
});

// Handle file input change event
fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    handleFile(file);
});

function handleFile(file) {
    if (file && file.type === 'application/pdf') {
        const pdfURL = URL.createObjectURL(file);

        // Display the PDF using an <iframe> element
        preview.style.display = 'block';
        preview.src = pdfURL;
    } else {
        // Reset the preview if the selected file is not a PDF
        preview.style.display = 'none';
        alert('Please select a valid PDF file.');
    }
}


// convert text to voice 

let speech = new SpeechSynthesisUtterance();
let voices = [];
let voiceSelect = document.querySelector("#select-voice");
let pauseBtn = document.querySelector("#pauseSynthesis");

window.speechSynthesis.onvoiceschanged = () => {
    voices = window.speechSynthesis.getVoices();
    speech.voice = voices[0];

    voices.forEach((voice, i) => (voiceSelect.options[i] = new Option(voice.name, i)));
};

voiceSelect.addEventListener("change", () => {
    speech.voice = voices[voiceSelect.value];
})

document.querySelector("button").addEventListener('click', () => {
    speech.text = text;
    window.speechSynthesis.speak(speech);
});
pauseBtn.addEventListener("click", () => {
    window.speechSynthesis.pause();
})
resumeBtn.addEventListener("click", () => {
    window.speechSynthesis.resume();
})
const converterFunction = (text) => {
    speech.text = text;
    window.speechSynthesis.speak(speech);
}

converterFunction("");
document.getElementById('convertBtn').addEventListener('click', async function () {
    const pdfInput = document.getElementById('pdfInput');
    const selectedFile = pdfInput.files[0];

    if (selectedFile) {
        const fileReader = new FileReader();
        fileReader.onload = async function (event) {
            const pdfData = new Uint8Array(event.target.result);
            const pdf = await pdfjsLib.getDocument({ data: pdfData }).promise;

            let pdfText = '';

            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                const page = await pdf.getPage(pageNum);
                const pageText = await page.getTextContent();
                pageText.items.forEach(item => {
                    pdfText += item.str + ' ';
                });
            }
            converterFunction(pdfText);
        };

        fileReader.readAsArrayBuffer(selectedFile);
    }
});


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
    document.getElementById("pdf-to-audio-page1").addEventListener("mouseenter", function (dets) {
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
    document.getElementById("pdf-to-audio-page1").addEventListener("mouseleave", function () {
        gsap.to("#main-cursor", {
            scale: 0,
            opacity: 0
        })
    })


    document.getElementById("pdf-to-audio-page2").addEventListener("mouseenter", function () {
        gsap.to("#main-cursor", {
            scale: 1,
            opacity: 1
        })
    })
    // document.getElementById("pdf-to-audio-page2").addEventListener("mousemove", function (dets) {
    //     gsap.to("#main-cursor", {
    //         left: dets.x - 15,
    //         top: dets.y - 10
    //     })
    // })

    document.getElementById("pdf-to-audio-page2").addEventListener("mouseleave", function () {
        gsap.to("#main-cursor", {
            scale: 0,
            opacity: 0
        })
    })
}
CursorMoving();
