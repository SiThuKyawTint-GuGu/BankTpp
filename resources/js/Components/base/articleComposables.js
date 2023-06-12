import { ref } from 'vue'
import {usePage} from "@inertiajs/inertia-vue3";

export function getArticleImageUrl(imgname) {
    if (imgname)
        return `../assets/articles/${imgname}`;
    // else
    //     return getRandomPixbayImage();
}

export function getArticleRating(inputvar) {
    return inputvar + Math.floor((Math.random() * 4) + 1);
}

export function getImageUrl(imgname) {
    if (imgname)
        return new URL(imgname, import.meta.url).href
}

export function convertToUnicode(tmptext) {
    return tmptext;
}

export function getPixbayImageByIndex(index) {

    const defaultPhoto = '/img/logo.png';
    if (usePage().props.value.pixbayphotos) {

        let pixaphoto = '';
        if (usePage().props.value.pixbayphotos[index])
            pixaphoto = usePage().props.value.pixbayphotos[index].webformatURL;

        return pixaphoto ? pixaphoto : defaultPhoto;

    } else {
        return defaultPhoto;
    }
}

export function getRandomPixbayImage() {
    const defaultPhoto = '/img/logo.png';
    if (usePage().props.value.pixbayphotos) {
        let pixaphoto = '';
        if (usePage().props.value.pixbayphotos[Math.floor((Math.random() * usePage().props.value.pixbayphotos.length - 1) + 1)].webformatURL)
            pixaphoto = usePage().props.value.pixbayphotos[Math.floor((Math.random() * usePage().props.value.pixbayphotos.length - 1) + 1)].webformatURL;

        return pixaphoto ? pixaphoto : defaultPhoto;

    } else {
        return defaultPhoto;
    }
}

export function getFirstWords(str, count) {
    var strarray = str.split(" ");
    var text = '';
    for (let i = 0; i < count; i++) {
        text += " " + strarray[i];
    }
    return text;
}

export function getTheRestWords(str, start) {
    var strarray = str.split(" ");
    var text = '';
    for (let i = start; i < strarray.length; i++) {
        text += " " + strarray[i];
    }
    return text;
}

export function redirect_to_article(article_id) {
    window.location.href = "/articles/" + article_id;
}

export function redirect_to_url (url) {
    window.location.href = url;
}

export function openurl_in_newwindow (url) {
    window.open(url, '_blank');
}

export function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

export function getEngTitle(tmptext) {
    let title_array = tmptext.split('-');
    return title_array[0];
}

export function getMmTitle(tmptext) {
    let title_array = tmptext.split('-');
    return title_array[1];
}

export function getLoanConditionTitle(titlekey, fieldlabels) {
    // console.log('Title Key - ' + titlekey);
    for (const itemkey in fieldlabels) {

        // console.log('Item Key - ' + itemkey);
        if (itemkey === titlekey)
            return fieldlabels[itemkey];
    }
}