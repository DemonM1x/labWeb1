

const xRadios = document.querySelectorAll('input[name="x"]');
const yText = document.querySelector('input[name="y"]');
const rCheckBoxes = document.querySelectorAll('input[name="r[]"]');
const formContainer = document.querySelector(".form-container");

const xErrorElement = document.getElementById("xError");
const yErrorElement = document.getElementById("yError");
const rErrorElement = document.getElementById("rError");

yText.addEventListener('input', function(e){
    var inputValue = e.target.value;
    var sanitizerValue = inputValue.replace(/[^0-9.\-]/g, '')
    e.target.value = sanitizerValue;
});

function showFormContainer() {
    if (
      xErrorElement.textContent ||
      yErrorElement.textContent ||
      rErrorElement.textContent
    ) {
      formContainer.style.display = "block";
    } else {
      formContainer.style.display = "none";
    }
  }
  

function sendFunction(){
    let selectedX;
    for(const xRadio of xRadios){
        if (xRadio.checked){
            selectedX = xRadio.value;
            break
        }
    }
    let selectedR;
    for(const rCheckBox of rCheckBoxes){
        if (rCheckBox.checked){
            selectedR = rCheckBox.value;
            break;
        }
    }

    xErrorElement.textContent = "";
    yErrorElement.textContent = "";
    rErrorElement.textContent = "";

    if (selectedX == null){
        xErrorElement.textContent = "Выберите координату X";
        return false;
    }
    const yValue = parseFloat(yText.value);

    if (isNaN(yValue)) {
        yErrorElement.textContent = "Неправильный формат ввода координаты Y";

        return false;
    }
    if (selectedR == null){
        rErrorElement.textContent = "Выберите радиус";

        return false;
    }
    selectedX = parseFloat(selectedX);

    if (![-4, -3, -2, -1, 0, 1, 2, 3, 4].includes(selectedX)) {
        xErrorElement.textContent = "Координата X должна быть одним из элементов массива: [-4, -3, -2, -1, 0, 1, 2, 3, 4]";

        return false;
    }
    if (yText.value == '' ||  parseFloat( yText.value) >= 5 || parseFloat(yText.value) <= -3 ){
        yErrorElement.textContent = "Введите координату Y корректно: (-3 , 5)";
        return false;
    }
    for(const rCheckBox of rCheckBoxes){
        selectedR = parseFloat(rCheckBox.value);
        if (![1, 2, 3, 4, 5].includes(selectedR)){
            rErrorElement.textContent = "Радиус R должен быть одним из элементов массива: [1, 2, 3, 4, 5]";
            return false;
        }
    }
    
    return true;
    
}