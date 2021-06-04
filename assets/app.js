/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

function onClickBtnLike(event){

    event.preventDefault();
    console.log("pass");

    const url = this.href;
    const spanCount = this.querySelector('span.js-recipelikes');
    const  icone = this.querySelector('i');

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.recipeLikes;

        console.log("ok");

        if (icone.classList.contains('fas')){
            icone.classList.replace('fas','far');
        }else{
            icone.classList.replace('far', 'fas');    
        }
   }).catch(function(error) {
       if(error.response.status === 403) {
           window.alert("vous ne pouvez pas liker un article si vous n'êtes pas connecté");
       }else{
        window.alert("une erreur s'est produite veuillez vous connecté");
       }
   });
}

document.querySelectorAll('a.js-recipeLike').forEach(function(link){
    link.addEventListener('click', onClickBtnLike)
});
