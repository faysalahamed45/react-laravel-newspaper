import React from 'react';
import America from '../components/Home/Amerika/America';
import ExclusiveAndLatest from '../components/Home/ExclusiveAndLatest/ExclusiveAndLatest';
import Features from '../components/Home/Features/Features';
import LatestAndVideo from '../components/Home/LatestAndVideo/LatestAndVideo';
import Footer from '../components/Shared/Footer/Footer';
import Navbar from '../components/Shared/Navbar/Navbar';

const Home = () => {
 return (
  <>
   <Navbar/>
	 <Features/>
	 <ExclusiveAndLatest/>
	 <America/>
	 <LatestAndVideo/>
   <Footer/>
  </>
 );
};

export default Home;