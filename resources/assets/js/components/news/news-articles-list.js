Vue.component('news-articles-list', {
    mixins: [
        require('../../mixins/lists-news-articles'),
        require('../../mixins/manages-news-articles')
    ]
});
