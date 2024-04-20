const createProfilePictureForm=document.querySelector("#createProfilePictureForm");
if(createProfilePictureForm)createProfilePictureForm.addEventListener("submit",createProfilePicture);

function createProfilePicture(e){
    const fname=e.target['fname'].value;
    const lname=e.target['lname'].value;
    const selfie=e.target['selfie'].value;
    const cover=e.target['cover'].value;
    const caption=e.target['caption'].value;
    if(!(fname && lname && selfie && cover && caption)){
        e.preventDefault();
        const p=document.createElement("p");
        p.textContent="Please enter your first name, last name, caption, cover photo, and selfie to create your profile picture.";
        p.classList.add('error');
        const error=e.target.querySelector(".error");
        if(error)error.remove();
        e.target.prepend(p);
    }
    const maxLength=15;
    if(caption.length>maxLength){
        e.preventDefault();
        const p=document.createElement("p");
        p.textContent=`Caption must be ${maxLength} characters or less`;
        p.classList.add('error');
        e.target.prepend(p);
    }
}