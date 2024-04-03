const qrCodeContainer = document.getElementById("qr-code");

// Generate the QR code using the QRCode.js library
const qrCode = new QRCode(qrCodeContainer, {
    text: "Your text here", // Replace "Your text here" with the actual text or URL you want to encode
    width: 128,
    height: 128,
});

qrCode.makeCode();

console.log(qrCode.makeCode());