document.addEventListener("DOMContentLoaded", function () {
    const firstLineText = "Enjoy your, SL";
    const secondLineText = "Comfort Food";
    const thirdLineText = "Kottu";

    const firstLineElement = document.querySelector(".first-line");
    const secondLineElement = document.querySelector(".second-line");
    const thirdLineElement = document.querySelector(".third-line");

    let index1 = 0, index2 = 0, index3 = 0;

    function typeFirstLine() {
        if (index1 < firstLineText.length) {
            firstLineElement.innerHTML += firstLineText[index1];
            index1++;
            setTimeout(typeFirstLine, 100);
        } else {
            setTimeout(typeSecondLine, 500); // Delay before typing the second line
        }
    }

    function typeSecondLine() {
        if (index2 < secondLineText.length) {
            secondLineElement.innerHTML += secondLineText[index2];
            index2++;
            setTimeout(typeSecondLine, 100);
        } else {
            setTimeout(typeThirdLine, 500); // Delay before typing 'Kottu'
        }
    }

    function typeThirdLine() {
        if (index3 < thirdLineText.length) {
            thirdLineElement.innerHTML += thirdLineText[index3];
            index3++;
            setTimeout(typeThirdLine, 100);
        }
    }

    typeFirstLine();
});
