import {BrowserRouter as Router} from "react-router-dom";
import app from "../../config/app";
import Header from "./Header";
import Footer from "./Footer";

export default function Layout({children}) {
    return (
        <Router basename={`${app.path}`}>
            <Header/>

            {children}

            <Footer/>
        </Router>
    );
}
