import React, { memo, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";
// import DateTimes from './DateTimesBangla';
import DateTimesBangla from "./DateTimesBangla";
import SideNavbar from "./SideNavbar";
import { fetchMenu } from "../../../Features/menu/menuSlice";
import SearchBar from "./SearchBar";
import BookData from "./Data.json";
import MomentConverter from "../../../MomentJs/MomentConverter";
// import "../../css/style.css";

const Navbar = () => {
    const [show, setShow] = useState(false);
    const [isSticky, setSticky] = useState(false);

    const { header } = useSelector(state => state.menu);

    useEffect(() => {
        let lastScroolTop = 0;
        const showHideHeader = () => {
            let scrollTop =
                window.pageYOffset;
            if (scrollTop > lastScroolTop) {
                setSticky(true);
            } else {
                setSticky(false);
            }
            lastScroolTop = scrollTop;
        };
        window.addEventListener("scroll", showHideHeader);
        return () => {
            window.removeEventListener("scroll", showHideHeader);
        };
    }, []);

		const dispatch = useDispatch();
    useEffect(() => {
        dispatch(fetchMenu());
    }, []);

    const toggle = () => {
        setShow(!show);
				if(show){
					document.body.style.overflow = "scroll";
				}else{
					document.body.style.overflow = "hidden";
				}
    };

    return (
        <>
            <header>
                <nav>
                    <div
                        id="nav-container"
                        className={` ${
                            isSticky ? "navbar-hide" : "navbar-show"
                        }`}
                    >
                        <div className="pt-3 position-relative">
                            <div className="container">
                                <div id="navbar" className="row nav-header">
                                    <div className="col-5 d-flex hamburge ">
                                        <div className="hamburger-container d-flex justify-content-center align-items-start">
                                            <label
                                                onClick={toggle}
                                                className={`hamburger-label ${
                                                    show
                                                        ? "hamburger-label1"
                                                        : ""
                                                }`}
                                            >
                                                <span className="hamburger-span d-block"></span>
                                                <span className="hamburger-span d-block mt-1"></span>
                                                <span className="hamburger-span d-block mt-1"></span>
                                            </label>

                                            <SideNavbar
                                                toggle={toggle}
                                                show={show}
                                            ></SideNavbar>
                                        </div>
                                        <div>
                                            <SearchBar placeholder="যা খুঁজতে চান" data={BookData}/>
                                        </div>
                                    </div>

                                    <div className="col-2 brand-name">
                                        <Link to="/">
                                            <p className="d-flex justify-content-center">
                                                ঠিকানা
                                            </p>{" "}
                                        </Link>
                                    </div>
                                    <div className="col-5 nav-date-time">
                                        <div className="d-flex justify-content-end">
                                            <span>
                                                <i className="fa-solid fa-bell m-0 p-0"></i>
                                            </span>
                                            <span className="ps-3 nav-date nav-date-english m-0">
                                                English
                                            </span>
                                        </div>
                                        <p className="nav-date d-flex justify-content-end">
                                            {/* <DateTimesBangla /> */}
																					  <MomentConverter date={new Date()} formate={'dddd, LL'}/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr style={{ margin: 0, padding: 0 }} />
                        </div>

                        <div className="navBar container-fluid d-xxl-block d-xl-block d-md-block d-none d-sm-none">
                            <div className="container h-100">
                                <ul className="d-flex justify-content-between align-items-center h-100 text-start ms-5 me-5 ps-5 pe-5">
                                    {header?.map(name => {
                                        return (
                                            <li key={name.id}>
                                                <Link to={`/${name?.slug_bn}`} onClick={() => window.scrollTo(0, 0)}>
                                                    {name?.name_bn}{" "}
                                                </Link>
                                            </li>
                                        );
                                    })}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div className="container ad">
                        <div className="row ">
                            <div className="col-10 m-auto">
                                <div className="header-advertising-card mt-3">
                                    <p className="d-flex justify-content-center align-items-center h-100 text-white">
                                        Ads
                                    </p>
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
