import React from "react";
import { useSelector } from "react-redux";
import MomentTo from "../../../MomentJs/MomentTo";
import FifthAndSixthCard from "./FirstFeatures/cardsContainer/FifthAndSixthCard";
import FirstCard from "./FirstFeatures/cardsContainer/FirstCard";
import FirstCardImage from "./FirstFeatures/cardsContainer/FirstCardImage";
import ForthCard from "./FirstFeatures/cardsContainer/ForthCard";
import ThirdCard from "./FirstFeatures/cardsContainer/ThirdCard";
import SecondFeature2ndAnd3rdCard from "./SecondFeatures/cardContainer/SecondFeature2ndAnd3rdCard";
import SecondFeatureFirstCard from "./SecondFeatures/cardContainer/SecondFeatureFirstCard";
import SecondFeatureFiveAndSixthCard from "./SecondFeatures/cardContainer/SecondFeatureFiveAndSixthCard";
import SecondFeatureFourthCard from "./SecondFeatures/cardContainer/SecondFeatureFourthCard";
import SecondFeatureRightSide from "./SecondFeatures/SecondFeatureRightSide";

const Features = () => {
    const {feature_post, feature_post_2} = useSelector(
        (state) => state.homePost
    );

    // console.log(amerika);
    // console.log(feature_post);
    // console.log(feature_post_2);
    // console.log(homePost);
    return (
        <div>
            <div className="container">
                <div className="row">
                    <div className="row-1st col-xxl-9 col-xl-9 col-md-9 col-sm-12 col-12">
                        <div className="row">
                            <FirstCard featuaresPost={feature_post} />
                            <FirstCardImage featuaresPost={feature_post} />
                            <ThirdCard featuaresPost={feature_post} />
                        </div>
                        <hr />
                        <div className="row">
                            <ForthCard featuaresPost={feature_post} />

                            <FifthAndSixthCard featuaresPost={feature_post} />
                        </div>
                        <hr />
                        <div className="row">

                            <SecondFeature2ndAnd3rdCard
                                secondFeatures={feature_post_2}
                            />
                            <SecondFeatureFirstCard
                                secondFeatures={feature_post_2}
                            />

                        </div>
                        <hr className="d-xxl-block d-xl-block d-md-block d-sm-none d-none" />
                        <div className="row">
                            <SecondFeatureFourthCard
                                secondFeatures={feature_post_2}
                            />
                            <SecondFeatureFiveAndSixthCard
                                secondFeatures={feature_post_2}
                            />
                        </div>
                    </div>
                    <div className="col-xxl-3 col-xl-3 col-md-3 col-sm-12 col-12">
                        <hr className="d-xxl-none d-xl-none d-md-none d-sm-block d-block" />
                        <div className="row">
                            <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-10 col-10 m-auto">
                                <div className="ad-container">
                                    <p className="d-flex justify-content-center align-items-center h-100 text-white">
                                        Ads
                                    </p>
                                </div>
                            </div>
                            <SecondFeatureRightSide
                                secondFeatures={feature_post_2}
                            />
                            <div className="container">
                                <hr />
                            </div>
                            <div className="col-xxl-12 col-xl-12 col-md-12 col-sm-10 col-10 m-auto">
                                <div className="sm-ads-container">
                                    <p className="d-flex justify-content-center align-items-center text-white h-100">
                                        Ads
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    );
};

export default Features;
