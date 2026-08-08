

function searchMedicine() {
  const query = document.getElementById("searchInput").value.trim();

  if(query === ""){
      alert("Please enter something to search.");
      return;
  }

  window.location.href = "search.php?query=" + encodeURIComponent(query);
}
