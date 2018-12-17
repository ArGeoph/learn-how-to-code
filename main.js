let newUrl, addButton, editButtons, cancelButtons, addBookmark, bookmarkFiels, bookmarkForm;
let addElement;    

//Method called when page is loaded for the first time
const initialize = () => {
  addElement = document.createElement("li");
  addElement.innerHTML = "<input type='text' name='newUrlName' class='bookmarkFiels' id='newUrlName' placeholder='Website name' autocomplete='off'/>" +
  "<input type='text' name='newUrl' class='bookmarkFiels urlField' id='newUrl' placeholder='Website URL'/ autocomplete='off'>" + 
  "<button class='bookmarkButton' formaction='loged.php' id='addButton'>Add</button>";  

  addBookmark = document.getElementById("addBookmark");
  bookmarkForm = document.getElementById("bookmarkForm");
  bookmarkFiels = document.getElementsByClassName("bookmarkFiels");
  editButtons = document.getElementsByClassName("editButton");
  cancelButtons = document.getElementsByClassName("cancelButton");

  //Add event listeners to objects
  addBookmark.addEventListener("click", showAddFields, true);
  
  //Add event listeners to edit buttons
  for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      $(event.currentTarget).next().show();
      $(event.currentTarget).next().next().show();
      $(event.currentTarget).prev().prev().hide();
      $(event.currentTarget).siblings(".bookmarkFiels").prop("disabled", false);
      $(event.currentTarget).siblings(":first").focus();
      $(event.currentTarget).hide();
    }, false);
  }

  //Add event listeners to cancel buttons
  for (let i = 0; i < cancelButtons.length; i++) {
    cancelButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      $(event.currentTarget).siblings("a").show();   
      $(event.currentTarget).siblings(".bookmarkFiels").prop("disabled", true);
      $(event.currentTarget).prev().hide();
      $(event.currentTarget).prev().prev().show();
      $(event.currentTarget).hide();
  
    }, false);
  }
};

// 
const showAddFields = () => {
  
  if (addBookmark.innerHTML === "Add new bookmark") {
    addBookmark.innerHTML = "Complete adding";
    
    bookmarkForm.appendChild(addElement);
    addButton = document.getElementById("addButton");
    addButton.addEventListener("click", addWebsite, false);

    newUrl = document.getElementById("newUrl");
    newUrl.addEventListener("focus", () => {
      if (newUrl.value === "") {
        newUrl.value = "http://www.";
      }
    }, false);
    newUrl.addEventListener("blur", () => {
      if (newUrl.value === "http://www.") {
        newUrl.value = "";
      }
    }, false);
  }
  else {    
    addBookmark.innerHTML = "Add new bookmark";
    bookmarkForm.removeChild(addElement);
  }
}

//If add button was pressed 
const addWebsite = async (event) => {
  event.preventDefault();
  if (newUrlName.value === "") {
    window.alert("Url name cannot be empty!");
    return;
  }

  if (newUrl.value.indexOf('.') < 0) { //Check if user input contains at least one dot, otherwise the web address is a priori invalid
    window.alert("Please enter valid web address!");
  }
  else {
    let isWebsiteValid = await checkWebsiteValidity(newUrl.value);

    if (isWebsiteValid) {
      alert (`${newUrl.value} is valid and added to bookmarks`);
      
      bookmarkForm.submit();
      newUrlName.value = ""
      newUrl.value = "";

    }
    else {
      window.alert("The entered web address is not active! Please check your input");
    }    
  }
};

//Method checking website validity 
const checkWebsiteValidity = async (url) => {
  try {
    const response = await fetch(`https://cors-anywhere.herokuapp.com/${url}`);

    if (response.ok) {
      console.log(response);
      return true;
    }
    else {
      return false;
    }
  }
  catch (networkError) {
    console.log(networkError);
    return false;
  }
};

window.addEventListener("load", initialize, false);