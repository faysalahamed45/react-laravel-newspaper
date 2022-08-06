import React from "react";

const DateTimesBangla = () => {
  const arg = {
    date: new Date().getDate(),
    month: new Date().getMonth() + 1,
    year: new Date().getFullYear(),
  };
  const monthName = [
    "জানুয়ারি",
    "ফেব্রুয়ারি",
    "মার্চ",
    "এপ্রিল",
    "মে",
    "জুন",
    "জুলাই",
    "আগস্ট",
    "সেপ্টেম্বর",
    "অক্টোবর",
    "নভেম্বর",
    "ডিসেম্বর",
  ];
  const dayName = [
    "শুক্রবার",
    "শনিবার",
    "রবিবার",
    "সোমবার",
    "মঙ্গলবার",
    "বুধবার",
    "বৃহস্পতিবার",
  ];
  const numBd = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
  const convertNumber = (n) =>
    n
      .toString()
      .split("")
      .map((num) => numBd[num])
      .join("");

  const getYear = (dmy) =>
    dmy.month <= 4 && dmy.date <= 13 ? dmy.year : dmy.year;
  const getMonthDate = (d, m) => {
    return { month: m - 1, date: d };
  };

  var GetdayName = dayName[new Date(arg.year, arg.month, arg.date).getDay()];
  let daymon = getMonthDate(arg.date, arg.month);
  const day = GetdayName;
  const date = convertNumber(daymon.date);
  const month = monthName[daymon.month];
  const year = convertNumber(getYear(arg));
  const today = `${day}, ${date} ${month} ${year}`;

  return (
    <div>
      <p>{today}</p>
    </div>
  );
};

export default DateTimesBangla;
