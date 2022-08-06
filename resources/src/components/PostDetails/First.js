import React, { memo, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useParams,useLocation} from 'react-router-dom';
import { fetchPost } from '../../Features/posts/postSlice';
import Second from '../Second';
import Navbar from '../Shared/Navbar/Navbar';

const First = () => {
 // let id = useParams();
 let location = useLocation();
 const path = location.pathname;
 console.log(path);

 const {posts,links} = useSelector((state) => state.posts);
 // console.log(header);

 const dispatch = useDispatch();
 useEffect(()=>{
  dispatch(fetchPost(path))
 },[])
 console.log(posts);
 console.log(links);
 return (
  <div>
   <Navbar/>
   <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Impedit veritatis quae, nam id a officiis magni asperiores quaerat error, autem porro, harum temporibus nulla voluptatem!</p>
  </div>
 );
};

export default memo(First);