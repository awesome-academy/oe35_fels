window.onbeforeunload = function () {
    return confirm("Are you sure you want to reload the page.");
};

function alertSubmit() {
    Swal.fire({
        icon: 'info',
        title: swalTitle,
        text: swalText,
        timer: 2000,
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: true,
    }).then((result) => {
        window.onbeforeunload = null;
        document.getElementById(lessonFormId).submit();
    });
};

const clock = document.getElementById(clockId);

function countDown(duration, display) {
    var timer = duration * 60;
    var interVal = setInterval(function () {
        let minutes = Math.floor(timer / 60);
        // convert to integer number - decimal
        let seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.innerHTML = `${minutes} : ${seconds}`;
        if (timer > 0) {
            --timer;
        } else {
            clearInterval(interVal);
            alertSubmit();
        }
    }, 1000);
}

countDown(time, clock);
