import { CheckIcon } from "@heroicons/react/solid";
import { FC } from "react";

interface ListProps {
    children: React.ReactNode[] | React.ReactNode;
}

export const CheckList: FC<ListProps> = ({
    children
}) => {
    return (
        <li className='pb-4 flex flex-row'>
            <CheckIcon className='h-8 w-8 text-pest-purple font-semibold pr-2' />
            {children}
        </li>
    );
}