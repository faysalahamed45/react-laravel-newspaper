import React from 'react';
import { useSelector } from 'react-redux';
import FirstCard from './CardBox/FirstCard';
import FourthCard from './CardBox/FourthCard';
import SecondCard from './CardBox/SecondCard';
import ThirdCard from './CardBox/ThirdCard';

const America = () => {
	const {amerika} = useSelector(
		(state) => state.homePost);
	return (
		<>
		<div className="container">
        <p className="cards-title-2">আমেরিকা</p>
        <div className="row third-container">
          <FirstCard amerika={amerika}/>
          <SecondCard amerika={amerika}/>
          <div
            className="col-xxl-4 col-xl-4 col-md-4 col-sm-10 col-10 third-container-ad m-xxl-0 m-xl-0 m-md-0 m-sm-auto m-auto"
          >
            <div
              className="third-container-card-ad my-xxl-0 my-xl-0 my-md-0 my-sm-3 my-3"
            >
              <p
                className="d-flex justify-content-center align-items-center text-white h-100"
              >
                Ads
              </p>
            </div>
          </div>

					<ThirdCard amerika={amerika}/>
          <FourthCard amerika={amerika}/>
          <div
            className="col-xxl-4 col-xl-4 col-md-4 col-sm-10 col-10 third-container-ad m-xxl-0 m-xl-0 m-md-0 m-sm-auto m-auto"
          >
            <div className="third-container-card-ad mt-3">
              <p
                className="d-flex justify-content-center align-items-center text-white h-100"
              >
                Ads
              </p>
            </div>
          </div>
        </div>
        <hr />
      </div>
		</>
	);
};

export default America;