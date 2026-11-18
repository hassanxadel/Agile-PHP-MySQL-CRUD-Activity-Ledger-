(function () {
  var root = document.documentElement;
  var stored = localStorage.getItem("theme");
  if (stored) root.setAttribute("data-theme", stored);

  var toggle = document.querySelector(".theme-toggle");
  if (toggle) {
    var sync = function () {
      var isDark = root.getAttribute("data-theme") === "dark" ||
        (!root.getAttribute("data-theme") && matchMedia("(prefers-color-scheme: dark)").matches);
      toggle.textContent = isDark ? "Light mode" : "Dark mode";
    };
    toggle.addEventListener("click", function () {
      var next = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
      root.setAttribute("data-theme", next);
      localStorage.setItem("theme", next);
      sync();
    });
    sync();
  }

  var tabs = Array.prototype.slice.call(document.querySelectorAll(".tabs a"));
  var panels = tabs.map(function (tab) {
    return document.querySelector(tab.getAttribute("href"));
  });

  function setActive(id) {
    tabs.forEach(function (tab) {
      tab.classList.toggle("is-active", tab.getAttribute("href") === "#" + id);
    });
  }

  if (window.IntersectionObserver && panels.length) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) setActive(entry.target.id);
      });
    }, { rootMargin: "-40% 0px -50% 0px" });
    panels.forEach(function (p) { if (p) observer.observe(p); });
  }
})();
