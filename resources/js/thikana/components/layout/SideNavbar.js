import React from "react";
import {useSelector} from "react-redux";
import {Link} from "react-router-dom";
import app from "../../config/app";

const SideNavbar = ({show, toggle}) => {
    const {hamburger} = useSelector(state => state.menu);

    return (
        <div id="side-nav" className={`row side-nav mb-4 ${show ? "side-nav-show" : "side-nav-hide"}`}>
            <div className="hamburger-container2">
                <label onClick={toggle} className="hamburger-label2">
                    <span className="hamburger-span2 d-block"></span>
                    <span className="hamburger-span2 d-block mt-1"></span>
                    <span className="hamburger-span2 d-block mt-1"></span>
                </label>
            </div>
            <div className="sideNav-float">
                <div className="sideNav-float-items w-100">
                    <div className="search d-flex d-md-none mt-4">
                        <input type="text" className="search__input" placeholder="যা খুঁজতে চান" />
                        <button className="search__submit d-flex align-items-center justify-content-center h-100" aria-label="submit search">
                            <i className="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>

                    {hamburger?.map(item => (
                        <p onClick={toggle} key={item.id}>
                            <Link to={`/categories/${item.slug}`} onClick={() => window.scrollTo(0, 0)}>
                                {item.name}
                            </Link>
                        </p>
                    ))}
                    <p>
                        <a href={`${app.url}/classified`}>ক্লাসিফাইড</a>
                    </p>
                    <span className="follow-text">অনুসরণ করুন</span>
                </div>
                <div className="brand-icon social-icon d-flex justify-content-between">
                    <a href="#">
                        <i className="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#">
                        <i className="fa-brands fa-youtube ps-3 cl-red"></i>
                    </a>
                    <a href="#">
                        <i className="fa-brands fa-twitter ps-3"></i>
                    </a>
                    <a href="#">
                        <i className="fa-brands fa-instagram ps-3 cl-red"></i>
                    </a>
                </div>
            </div>
        </div>
    );
};

export default SideNavbar;
