import { FC } from "react";

interface PopularSearchItemProps {
    children: string;
}

export const PopularSearchItem: FC<PopularSearchItemProps> = ({
    children
}) => {
    return (
        <div className='bg-black/30 px-2 py-1 capitalize rounded-md w-fit'>
            <p className='text-white opacity-100'>{children}</p>
        </div>
    )
}