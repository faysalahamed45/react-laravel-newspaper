import React from "react";

const TopRead = ({showContent}) => {
    return (
        <>
            <div className={`${showContent ? "checkboxShow":"checkboxHide"}`}>
                <div id="1" className="most-read">
                    <div className="number-flex">
                        <p className="fourth-card-number">১</p>
                        <p className="cards-title-4 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-2 ps-3">
                            তাণ্ডব চালানো সার্কাসের হাতিটি সাত ঘণ্টা পর মাহুতের
                            নিয়ন্ত্রণে
                        </p>
                    </div>
                    <hr />
                    <div className="number-flex">
                        <p className="fourth-card-number">২</p>
                        <p className="cards-title-4 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-2 ps-3">
                            তাণ্ডব চালানো সার্কাসের হাতিটি সাত ঘণ্টা পর মাহুতের
                            নিয়ন্ত্রণে
                        </p>
                    </div>
                    <hr />
                    <div className="number-flex">
                        <p className="fourth-card-number">৩</p>
                        <p className="cards-title-4 mb-0 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-2 ps-3">
                            তাণ্ডব চালানো সার্কাসের হাতিটি সাত ঘণ্টা পর মাহুতের
                            নিয়ন্ত্রণে
                        </p>
                    </div>
                    <hr />
                    <div className="number-flex">
                        <p className="fourth-card-number">৪</p>
                        <p className="cards-title-4 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-2 ps-3">
                            তাণ্ডব চালানো সার্কাসের হাতিটি সাত ঘণ্টা পর মাহুতের
                            নিয়ন্ত্রণে
                        </p>
                    </div>
                </div>
            </div>
        </>
    );
};

export default TopRead;
