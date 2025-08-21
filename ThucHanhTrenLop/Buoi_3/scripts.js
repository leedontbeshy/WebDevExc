function addToSum(value){
    sum += value;
    document.getElementById("sum").innerText = "Current"
}

function createButtons(length) {
    let btn = document.createElement("button");
    for(let i = 0; i < length; i++){
        const button = btn.cloneNode(true);
        button.addEventListener("click", function(){
            addToSum(i + 1);
        });
        button.innerText = "Button " + (i + 1);
        document.body.appendChild(button);
    }
};