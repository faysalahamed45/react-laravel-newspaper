import React from 'react';

const DateTimes = () => {
  // const objToday = new Date().toLocaleTimeString;
  const weekday = new Array(
   'রবিবার',
   'সোমবার',
   'মঙ্গলবার',
    'বুধবার',
    'বৃহস্পতিবার',
    'শুক্রবার',
    'শনিবার'
  
  );
  const dayOfWeek = weekday[new Date().getDay()];
  const months = new Array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  );
  const curDate = new Date().getDate();
  const curMonth = months[new Date().getMonth()];
  const curYear = new Date().getFullYear();
  const today = `${dayOfWeek}, ${curDate} ${curMonth} ${curYear}`;

  // curMeridiem = objToday;

  // const showDate = new Date();
  // const displayTodayDate =
  // 	showDate.getDay()
  // const dt = displayTodayDate.toString();
  // const toDayDate = showDate.toLocaleDateString();

  return (
    <div>
      <p>{today}</p>
    </div>
  );
};

export default DateTimes;
