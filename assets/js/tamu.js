// buat elemen img
var img = document.createElement('img');
var context;

// seleksi elemen video dan canvas
var video = document.querySelector("#video-webcam");

function aturIzin() {
    // kosongkan value base64 foto tamu
    document.getElementById("fotobase").value = "";

    // minta izin user
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

    // jika user memberikan izin
    if (navigator.getUserMedia) {
        // jalankan fungsi handleVideo, dan videoError jika izin ditolak
        navigator.getUserMedia({ video: true }, handleVideo, videoError);
    }
}

function offKamera() {
    var stream = video.srcObject;
    var tracks = stream.getTracks();

    for (var i = 0; i < tracks.length; i++) {
        var track = tracks[i];
        track.stop();
    }

    video.srcObject = null;
}

// fungsi ini akan dieksekusi jika izin telah diberikan
function handleVideo(stream) {
    video.srcObject = stream;
}

// fungsi ini akan dieksekusi kalau user menolak izin
function videoError(e) {
    // do something
    alert("Izinkan menggunakan kamera untuk foto")
}

function takeSnapshot() {

    // ambil ukuran video
    var width = 320
        , height = 240;

    // buat elemen canvas
    canvas1 = document.createElement('canvas');
    canvas1.width = width;
    canvas1.height = height;

    // ambil gambar dari video dan masukan 
    // ke dalam canvas
    context = canvas1.getContext('2d');
    context.drawImage(video, 0, 0, width, height);

    //render hasil dari canvas ke elemen img
    img.src = canvas1.toDataURL('image/jpg');

    imagebase64 = canvas1.toDataURL('image/jpg');
    var data = imagebase64.replace('data:image/png;base64,', '')

    //document.body.appendChild(img);
    if (document.getElementById("foto").hasChildNodes()) {
        document.getElementById("foto").removeChild(img);
        document.getElementById("foto").appendChild(img);
        document.getElementById("fotobase").value = data;
    } else {
        document.getElementById("fotobase").value = data;
        document.getElementById("foto").appendChild(img);
    }

    offKamera();
}