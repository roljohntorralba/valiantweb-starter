import _ from "lodash";

function component() {
  const element = document.createElement("div");
  const btn = document.createElement("button");

  element.innerHTML = _.join(["Hello", "webpack"], " ");

  btn.innerHTML = "Don't click me.";
  btn.onclick = (e) => {
    btn.innerHTML = "You little rebel you!"
  };

  element.appendChild(btn);

  return element;
}

// document.body.appendChild(component());
