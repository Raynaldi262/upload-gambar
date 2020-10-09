function preview() {
    const nama = document.querySelector("#image");
    const namaLabel = document.querySelector(".custom-file-label");
    const imgPreview = document.querySelector(".img-preview");

    namaLabel.textContent = nama.files[0].name;

    const fileNama = new FileReader();
    fileNama.readAsDataURL(nama.files[0]);

    fileNama.onload = function (e) {
        imgPreview.src = e.target.result;
    };
}
