{
  {
    parent();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const dropdownButton = document.querySelector("#teamDropdown");
  const dropdownItems = document.querySelectorAll(".dropdown-item");

  dropdownItems.forEach((item) => {
    item.addEventListener("click", function (event) {
      event.preventDefault();
      const clickedTeam = event.target.getAttribute("data-team");
      const currentTeamText = dropdownButton.textContent.trim();
      const clickedTeamText = this.textContent;

      dropdownButton.textContent = clickedTeamText;
      this.textContent = currentTeamText;

      // Mettez ici la logique pour charger les joueurs de l'équipe sélectionnée
    });
  });
});
