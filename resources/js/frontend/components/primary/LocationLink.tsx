// font-semibold text-black h-1/2 overflow-hidden text-ellipsis whitespace-normal max-h-36 leading-6 line-clamp-6
import { FC } from "react"

interface LocationLinkProps {
    children: string;
}

export const LocationLink: FC<LocationLinkProps> = ({
    children
}) => {
    return (
        <p className='font-semibold text-black overflow-hidden text-ellipsis whitespace-normal leading-6 line-clamp-6 mx-2 my-1'>{children}</p>
    )
}