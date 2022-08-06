import React, {memo, useEffect, useState} from "react";
import {useSelector} from "react-redux";
import {Link} from "react-router-dom";
import Moment from "react-moment";
import SideNavbar from "./SideNavbar";
import app from "../../config/app";
import BookData from "../../../../src/components/Shared/Navbar/Data.json";
import SearchBar from "../../../../src/components/Shared/Navbar/SearchBar";

const Navbar = () => {
    const [show, setShow] = useState(false);
    const [isSticky, setSticky] = useState(false);

    const {header} = useSelector(state => state.menu);

    useEffect(() => {
        let lastScrollTop = 0;
        const showHideHeader = () => {
            let scrollTop = window.pageYOffset;
            if (scrollTop > lastScrollTop) {
                setSticky(true);
            } else {
                setSticky(false);
            }
            lastScrollTop = scrollTop;
        };
        window.addEventListener("scroll", showHideHeader);

        return () => {
            window.removeEventListener("scroll", showHideHeader);
        };
    }, []);

    const toggle = () => {
        setShow(!show);
        if (show) {
            document.body.style.overflow = "auto";
        } else {
            document.body.style.overflow = "hidden";
        }
    };

    return (
        <>
            <header>
                <nav>
                    <div id="nav-container" className={`${isSticky ? "navbar-hide" : "navbar-show"}`}>
                        <div className="pt-md-3 position-relative">
                            <div id="navbar" className="container nav-header d-flex justify-content-between">
                                <div className="d-flex hamburge">
                                    <div className="hamburger-container d-flex justify-content-center align-items-start">
                                        <label onClick={toggle} className={`hamburger-label ${show ? "hamburger-label1" : ""}`}>
                                            <span className="hamburger-span d-block"></span>
                                            <span className="hamburger-span d-block mt-1"></span>
                                            <span className="hamburger-span d-block mt-1"></span>
                                        </label>

                                        <SideNavbar toggle={toggle} show={show}></SideNavbar>
                                    </div>
                                    <div className="d-none d-md-block">
                                        <SearchBar placeholder="যা খুঁজতে চান" data={BookData} />
                                    </div>
                                </div>

                                <div className="brand-name">
                                    <Link to="/">
                                        <p className="text-center">
                                            <img className="thikana-logo" src={`${app.url}/admin-assets/images/logo.png`} />
                                        </p>
                                    </Link>
                                </div>
                                <div className="nav-date-time">
                                    <div className="d-none d-md-flex justify-content-end">
                                        <span>
                                            <i className="fa-solid fa-bell m-0 p-0"></i>
                                        </span>
                                        <span className="ps-3 nav-date nav-date-english m-0">English</span>
                                    </div>
                                    <p className="nav-date d-none d-md-flex justify-content-end">
                                        {/* <DateTimesBangla /> */}
                                        <Moment locale="bn" date={new Date()} format={"dddd, LL"} />
                                    </p>
                                    <p className="langs d-block d-md-none">
                                        <a href="#" className="lang active">
                                            বাংলা
                                        </a>
                                        |
                                        <a href="#" className="lang">
                                            English
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <hr style={{margin: 0, padding: 0}} />
                        </div>

                        <div className="navBar container-fluid d-xxl-block d-xl-block d-md-block d-none d-sm-none">
                            <div className="container h-100">
                                <ul className="d-flex justify-content-between align-items-center h-100 text-start ms-5 me-5 ps-5 pe-5">
                                    {header?.map(item => (
                                        <li key={item.id}>
                                            <Link to={`/categories/${item.slug}`} onClick={() => window.scrollTo(0, 0)}>
                                                {item.name}
                                            </Link>
                                        </li>
                                    ))}
                                    <li>
                                        <a href={`${app.url}/classified`}>ক্লাসিফাইড</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div className="container ad">
                        <div className="row ">
                            <div className="col-10 m-auto">
                                <div className="header-advertising-card mt-3">
                                    <p className="d-flex justify-content-center align-items-center h-100 text-white">Ads</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <hr className="header-hr" />
            </header>
        </>
    );
};

export default memo(Navbar);
