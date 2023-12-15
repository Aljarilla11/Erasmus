window.addEventListener("load",function(){

    const player = document.getElementById('player');
/* const anotherPlayer = document.getElementById('anotherPlayer');
 */
const constraints = {
    video: true,
};

navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
    player.srcObject = stream;
});


  const canvas = document.getElementById('canvas');
  const context = canvas.getContext('2d');
  const captureButton = document.getElementById('capture');

 

  captureButton.addEventListener('click', () => {
    // Draw the video frame to the canvas.
    context.drawImage(player, 0, 0, canvas.width, canvas.height);
  });

  // Attach the video stream to the video element and autoplay.
  navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
    player.srcObject = stream;
  });



})