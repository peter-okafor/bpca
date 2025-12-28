import { savePestList, saveSelectedPest, saveSelectedPostcode, selectPestList, selectSearchOpen, selectSelectedPest, selectSelectedPostcode, saveSearchOpen } from '@/Pages/Frontend/Home/homeSlice';
import { Inertia } from '@inertiajs/inertia';
import React, { useEffect, useState } from 'react';
import api from '../api';
import { Button, Input, InputGroup, MyComboBox } from '../components';
import { Pest } from '../data/models';
import { useAppDispatch, useAppSelector } from '../redux/hooks';
import { LoadingButton } from '../components/primary/LoadingButton';

interface SearchProps extends React.HTMLAttributes<HTMLDivElement> {
    showTitle?: boolean;
    horizontal?: boolean;
    hideLabel?: boolean;
    defaultPest?: string;
    defaultPostcode?: string;
    defaultOpen?: boolean;
    width?: string;
    postCodeError: boolean;
}

export const Search: React.FC<SearchProps> = ({
    showTitle = true,
    horizontal = false,
    hideLabel = false,
    postCodeError,
    defaultPest = '',
    defaultPostcode = '',
    defaultOpen = true,
    width = '',
    ...props
}) => {
    // Local state
    const [pestsData, setPestsData] = useState([]);
    // const [pests, setPests] = useRemember<Pest[]>([]);
    const dispatch = useAppDispatch();

    const pests = useAppSelector(state => selectPestList(state));
    const pest = useAppSelector(state => selectSelectedPest(state));
    const postcode = useAppSelector(state => selectSelectedPostcode(state));
    const open = useAppSelector(state => selectSearchOpen(state));

    const setPest = (pest: string) => {
        dispatch(saveSelectedPest(pest))
    }

    const setPostcode = (postcode: string) => {
        dispatch(saveSelectedPostcode(postcode))
    }

    const setOpen = (open: boolean) => {
        dispatch(saveSearchOpen(open))
    }

    const [postCodeRequired, setPostCodeRequired] = useState(false);
    const [pestRequired, setPestRequired] = useState(false);
    const [loading, setLoading] = useState(false);

    const ErrorAlert = ({text}) => {
        return (
            <div className="mt-2 flex items-center space-x-2 rounded-md bg-white text-pest-rose py-2 text-sm bg-opacity-90 px-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth={1.5}
                    stroke="currentColor"
                    className="w-6 h-6"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                    />
                </svg>
                <div className="mt-1">{text}</div>
            </div>
        );
    }
    useEffect(() => {
        if (pests.length === 0) {
            api.get('/pests').then(data => {
                if (data.status === 200) {
                    dispatch(savePestList(data.data.pests))
                    setPestsData(data.data.pests);
                }
            })
        }
    }, [pests]);

    const handleSubmit = () => {
        setLoading(true);

        if (!postcode) {
            setPostCodeRequired(true);
            setLoading(false);
        } else {
            setPostCodeRequired(false);
        }

        if (!pest.length) {
            setPestRequired(true);
            setLoading(false);
        } else {
            setPestRequired(false);
        }
        
        if (open) {
            if (pest && postcode) {
                let service = pests.find(v => v.name === pest);
    
                if (!!service?.code && !!postcode) {            
                    window.location.href = `/pest-controllers?pest=${service.code}&postcode=${postcode}`;
                    setLoading(false);
                }
                
                setLoading(false);
                // setOpen(!open);
            }
        } else {
            // setOpen(true)
            setPostCodeRequired(true)
            setLoading(false);
        }
    }

    const { className } = props;

    return (
        <section
            className={`bg-transparent grid ${
                horizontal ? "grid-cols-3" : "grid-cols-1"
            } ${className}`}
        >
                <>
                    <h1 className="font-semibold text-4xl text-white leading-normal md:w-full pb-8">
                        Find a pest controller
                    </h1>

                    <div className={`${horizontal ? "mr-2" : `pb-6 ${width}`}`}>
                        <InputGroup
                            label="Type of pest problem"
                            labelClassName={`${hideLabel ? "hidden" : ""}`}
                            // className={`bg-gray-400`}
                        >
                            <MyComboBox
                                placeholder="Pest Type"
                                options={pests?.map((p) => p.name)}
                                selected={pest}
                                onSelected={(v) => setPest(v)}
                            />

                            {pestRequired && (
                                <ErrorAlert
                                    text={`Pest is required.`}
                                />
                            )}
                        </InputGroup>
                    </div>
                    <div className={`${horizontal ? "mr-2" : `pb-6 ${width}`}`}>
                        <InputGroup
                            label="Place or Postcode"
                            labelClassName={`${hideLabel ? "hidden" : ""}`}
                        >
                            <Input
                                placeholder="Enter place or postcode"
                                value={postcode}
                                onChange={(e) => {
                                    setPostcode(e.target.value);
                                }}
                            />

                            {postCodeRequired && (
                                <ErrorAlert
                                    text={`Postcode is required.`}
                                />
                            )}
                        </InputGroup>

                        {postCodeError && (
                            <ErrorAlert
                                text={`Place or postcode provided is out of range, try again.`}
                            />
                        )}
                    </div>
                </>

            <div className={width}>
                <LoadingButton primary={true} load={loading} label="Search" onClick={handleSubmit} />
            </div>
        </section>
    );
}