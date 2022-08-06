import {memo, useEffect, useState} from "react";
import {Link} from "react-router-dom";
import httpClient from "@classified/core/axios";

const Header = () => {
    const [categories, setCategories] = useState([]);

    useEffect(() => {
        console.log("Header Component Mounted.");
        httpClient.get("/category").then(response => {
            if (response.data.success) {
                setCategories(response.data.data);
            }
        });
    }, []);

    return (
        <header className="containers">
            <div className="nav-header d-flex justify-content-between align-items-center mt-5 mb-5">
                <Link to={"/"} className="text-decoration-none">
                    <div className="brand-name d-flex align-items-center">
                        ঠিকানা
                        <br /> ক্লাসিফাইড
                    </div>
                </Link>
                <div className="nav-search d-flex align-items-center">
                    <span className="nav-hover nav-search-arrow ms-2">
                        <i className="fa-solid fa-angle-down fa-2x" />
                    </span>
                    <ul className="list-unstyled nav-hover-ul px-2 px-md-4 pt-2">
                        {categories.map(category => (
                            <li key={category.id} className="px-2">
                                <Link className="ps-2" to={`/categories/${category.slug}`}>
                                    {category.name} ({category.posts_count || 0})
                                </Link>
                            </li>
                        ))}
                    </ul>
                    <div className="input text-center d-flex align-items-center justify-content-center">ক্যাটাগরি অনুসারে সার্চ করুন</div>
                    <span className="nav-search-icon me-2">
                        <i className="fa-solid fa-magnifying-glass fa-xl" />
                    </span>
                </div>
                <div className="filter d-flex align-items-center justify-content-between">
                    <span className="filter-name me-1">ফিল্টার</span>
                    <i id="filter-icon" className="bi bi-filter fs-1" />
                    <ul className="filter-ul text-end list-unstyled text-decoration-none px-1 px-md-3 mt-3">
                        <li>
                            <Link className="pe-3" to="/filters/premium">
                                প্রিমিয়াম বিজ্ঞাপন
                            </Link>
                        </li>
                        <li>
                            <Link className="pe-3" to="/filters/new">
                                নতুন বিজ্ঞাপন
                            </Link>
                        </li>
                        <li>
                            <Link className="pe-3" to="/filters/old">
                                পুরনো বিজ্ঞাপন
                            </Link>
                        </li>
                        <li>
                            <Link className="pe-3" to="/filters/generate">
                                সাধারণ বিজ্ঞাপন
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
            <div className="header-img mb-5">
                <img className="img-fluid w-100 h-100" src={baseUrl + "/img/Screenshot 2022-04-06 at 1.53 1.png"} alt="" />
            </div>
        </header>
    );
};

export default memo(Header);
