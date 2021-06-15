function onClickBtnLike(event){
    event.preventDefault();
    console.log("pass");

    const url = this.href;
    const spanCount = this.querySelector('span.js-recipeLikes');
    const  icone = this.querySelector('i');

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.recipeLikes;

        if (icone.classList.contains('fas')){
            icone.classList.replace('fas','far');
        }else{
            icone.classList.replace('far', 'fas');    
        }
   }).catch(function(error) {
       if(error.response.status === 403) {
           window.alert("vous ne pouvez pas liker un article si vous n'êtes pas connecté");
       }
   }); 
}

document.querySelectorAll('a.js-like').forEach(function(link){
    link.addEventListener('click', onClickBtnLike)
});