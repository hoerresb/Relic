import Home from './pages/home.vue';
import SinglePost from './posts/single-post.vue';
import Page from './pages/page.vue';
import Author from './users/author.vue';
import Contact from './pages/contact.vue';
import Team from './pages/team.vue';
import Ethos from './pages/ethos.vue';

// remove thomas hooper for actual website
export const routes         =   [
    { path: '/' , component: Home },
    { path: '/team' , component: Team },
    { path: '/news' , component: Home },
    { path: '/ethos' , component: Ethos },
    { path: '/contact' , component: Contact },
    { path: '/post/:slug/:id', component: SinglePost },
    { path: '/:slug', component: Page },
];