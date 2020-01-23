function toggleMenu() {
  var m = document.getElementById("menu");
  if (window.getComputedStyle(m, null).getPropertyValue("display") === "none") {
    m.className = "menuo";
  } else {
    m.className = "menuc";
  }
}
