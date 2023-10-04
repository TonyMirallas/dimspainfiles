import dayjs from 'dayjs';

export const dateToFormat = (date) => dayjs(date).format('DD/MM/YYYY');
export const dateTimeToFormat = (date) => dayjs(date).format('DD/MM/YYYY');


