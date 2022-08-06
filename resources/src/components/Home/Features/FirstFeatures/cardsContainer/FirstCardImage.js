import React from "react";
import { Link } from "react-router-dom";

const FirstCardImage = ({ featuaresPost }) => {
    return (
        <>
            {featuaresPost?.slice(0, 1).map((postContent) => {
                return (
                    <div key={postContent.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 ps-0 pe-xxl-2 pe-xl-2 pe-md-3 pe-sm-0 pe-0 order-xxl-1 order-xl-1 order-md-1 order-sm-0 order-0 overflow-hidden">
                        <Link to={`/${postContent?.slug_bn}`}>
                            <div className="thikana-1st-content-img overflow-hidden">
                                <img className="w-100 h-100 img-fluid" src={postContent?.image_url} alt="" />
                            </div>
                            <figcaption className="pt-2 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-3 ps-3">
                            ছাত্রদলের দুই নেতা–কর্মীকে শহীদুল্লাহ হলের ড্রেনে
                            ফেলে পেটানো হয় | ছবি: প্রথম আলো
                            </figcaption>
                        </Link>
                    </div>
                );
            })}
        </>
    );
};

export default FirstCardImage;
