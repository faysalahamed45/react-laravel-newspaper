import React from "react";
import {Link} from "react-router-dom";
import {useSelector} from "react-redux";

const Footer = () => {
    const {footer} = useSelector(state => state.menu);

    return (
        <>
            <div className="container mt-4">
                <div className="row">
                    <div className="col-md-12">
                        <p className="cards-title-2">ঠিকানা</p>
                    </div>
                    <div className="col-md-8">
                        <div className="row">
                            {footer?.map(item => {
                                return (
                                    <div key={item.id} className="col-6 col-md-4 py-2">
                                        <Link className="text-decoration-none text-body footer-text" to={`/categories/${item.slug}`} onClick={() => window.scrollTo(0, 0)}>
                                            {item.name}
                                        </Link>
                                    </div>
                                );
                            })}
                        </div>
                    </div>

                    <div className="col-md-4 mt-5 mt-md-0">
                        <div className="w-100 mb-4">
                            <div className="brand-icon w-100 mb-4">
                                <p className="p-0 mb-2">অনুসরণ করুন</p>
                                <div>
                                    <a href="#">
                                        <i className="fa-brands fa-facebook"> </i>
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

                            <div className="w-100">
                                <p className="p-0 mb-2">মোবাইল অ্যাপস ডাউনলোড করুন</p>
                                <div className="d-flex gap-2">
                                    <div>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="140" height="40" className="svg-android">
                                                <g data-name="Group 4686" transform="translate(-410 -926.5)">
                                                    <rect width="140" height="40" data-name="Rectangle 60" rx="2" transform="translate(410 926.5)" fill="#222"></rect>
                                                    <g data-name="Group 4523" fill="#ccc">
                                                        <g data-name="Group 2992">
                                                            <text data-name="Android app on" transform="translate(458.735 940.5)" fontSize="8" fontFamily="ArialMT,Arial">
                                                                <tspan x="0" y="0">
                                                                    Android app on
                                                                </tspan>
                                                            </text>
                                                            <text
                                                                data-name="Google Play"
                                                                transform="translate(458.735 955.5)"
                                                                fontSize="12"
                                                                fontFamily="Arial-BoldMT,Arial"
                                                                fontWeight="700"
                                                                className="grow-android-text">
                                                                <tspan x="0" y="0">
                                                                    Google Play
                                                                </tspan>
                                                            </text>
                                                        </g>
                                                        <path
                                                            d="M446.889 946.07l-9.485-9.511 12.068 6.928-2.583 2.583zM434.928 936a1.671 1.671 0 00-.932 1.517v18.966a1.671 1.671 0 00.932 1.517l11.028-11zm18.274 9.7l-2.531-1.466-2.824 2.772 2.824 2.772 2.583-1.465a1.723 1.723 0 00-.052-2.613zm-15.8 11.75l12.068-6.928-2.581-2.587z"
                                                            data-name="Path 535"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="140" height="40" className="svg-apple">
                                                <g data-name="Group 4685" transform="translate(-570 -926.5),scale(1)">
                                                    <rect width="140" height="40" data-name="Rectangle 101" rx="2" transform="translate(570 926.5)" fill="#222"></rect>
                                                    <g data-name="Group 4524" fill="#ccc">
                                                        <text data-name="Available on the" transform="translate(619.279 940.5)" fontSize="8" fontFamily="ArialMT,Arial">
                                                            <tspan x="0" y="0">
                                                                Available on the
                                                            </tspan>
                                                        </text>
                                                        <text
                                                            data-name="App Store"
                                                            transform="translate(619.279 955.5),scale(1)"
                                                            fontSize="12"
                                                            fontFamily="Arial-BoldMT,Arial"
                                                            fontWeight="700"
                                                            className="grow-apple-text">
                                                            <tspan x="0" y="0">
                                                                App Store
                                                            </tspan>
                                                        </text>
                                                        <path
                                                            d="M609.457 945.626a4.585 4.585 0 012.456-4.165 5.279 5.279 0 00-4.16-2.191c-1.744-.137-3.649 1.017-4.347 1.017-.737 0-2.426-.967-3.752-.967-2.741.044-5.654 2.185-5.654 6.542a12.228 12.228 0 00.708 3.988c.628 1.8 2.9 6.223 5.265 6.149 1.238-.029 2.112-.879 3.723-.879 1.562 0 2.372.879 3.752.879 2.387-.034 4.44-4.052 5.04-5.859a4.869 4.869 0 01-3.031-4.514zm-2.78-8.065a4.627 4.627 0 001.179-3.561 5.211 5.211 0 00-3.335 1.714 4.7 4.7 0 00-1.257 3.532 4.123 4.123 0 003.413-1.685z"
                                                            className="grow-apple"
                                                            data-name="Path 536"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <hr className="mb-2 pb-0" />
            </div>
            <div className="container">
                
                <div className="py-2 footer-text footer-policy">
                    <ul className="d-flex justify-content-center gap-3 list-unstyled m-0">
                        <li>
                            <Link className="text-body" to="/AboutUs">
                                আমাদের সম্পর্কে
                            </Link>
                        </li>
                        <li>
                            <Link className="text-body" to="/Policy">
                                নীতিমালা
                            </Link>
                        </li>
                        <li>
                            <Link className="text-body" to="/Contact Us">
                                যোগাযোগ
                            </Link>
                        </li>
                    </ul>
                </div>
                <hr className="mb-2 pb-0" />
            </div>

            <div className="container-fluid copyright">
                <p className="d-flex align-items-center justify-content-center h-100">© 2022 All Rights Reserved by Thikana Group Of Media</p>
            </div>
        </>
    );
};

export default Footer;
